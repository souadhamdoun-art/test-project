<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;
use App\TwitterClient;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CourseNotificationService
{
    public function __construct(
        private TwitterClient $twitterClient,
        private Calculator $calculator
    ) {}

    /**
     * Notifie les utilisateurs d'un nouveau cours
     */
    public function notifyNewCourse(Course $course, array $users): array
    {
        $results = [
            'email_sent' => 0,
            'twitter_posted' => false,
            'total_users' => count($users),
            'discount_applied' => false
        ];

        // Calculer une remise si plus de 10 utilisateurs
        if ($results['total_users'] > 10) {
            $discountPercentage = $this->calculator->divide(
                $this->calculator->multiply($results['total_users'], 2),
                100
            );
            $results['discount_applied'] = $discountPercentage;
        }

        // Envoyer des emails aux utilisateurs
        foreach ($users as $user) {
            try {
                Mail::raw("Nouveau cours disponible: {$course->title}", function ($message) use ($user, $course) {
                    $message->to($user->email)->subject('Nouveau cours: ' . $course->title);
                });
                $results['email_sent']++;
            } catch (\Exception $e) {
                Log::error('Failed to send email', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            }
        }

        // Poster sur Twitter si le cours a plus de 5 utilisateurs intéressés
        if ($results['total_users'] > 5) {
            try {
                $tweetMessage = "Nouveau cours disponible: {$course->title} - {$results['total_users']} personnes intéressées!";
                $this->twitterClient->tweet($tweetMessage);
                $results['twitter_posted'] = true;
            } catch (\Exception $e) {
                Log::error('Failed to post tweet', ['course_id' => $course->id, 'error' => $e->getMessage()]);
            }
        }

        return $results;
    }
}

