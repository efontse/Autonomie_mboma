<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait NotificationHelper
{
    /**
     * Créer une notification
     */
    protected function createNotification(int $userId, string $type, string $message, array $data = []): Notification
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'message' => $message,
            'data' => $data,
            'lu' => false,
        ]);
    }

    /**
     *Notifier l'administrateur (pour les actions des utilisateurs)
     */
    protected function notifyAdmin(string $type, string $message, array $data = []): void
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $this->createNotification($admin->id, $type, $message, $data);
        }
    }

    /**
     *Notifier un utilisateur spécifique
     */
    protected function notifyUser(int $userId, string $type, string $message, array $data = []): void
    {
        // Ne pas envoyer de notification à l'utilisateur connecté
        if (Auth::check() && Auth::id() === $userId) {
            return;
        }

        $this->createNotification($userId, $type, $message, $data);
    }

    /**
     * Notification d'inscription à une formation
     * Notifie l'administrateur et l'utilisateur
     */
    protected function notifyInscriptionFormation(int $userId, string $formationTitre): void
    {
        // Notification pour l'utilisateur
        $this->createNotification(
            $userId,
            'inscription_formation',
            "Vous êtes maintenant inscrit à la formation : {$formationTitre}",
            ['formation_titre' => $formationTitre]
        );

        // Notification pour l'administrateur
        $this->notifyAdmin(
            'inscription_formation',
            "Nouvel utilisateur inscrit à la formation : {$formationTitre}",
            ['user_id' => $userId, 'formation_titre' => $formationTitre]
        );
    }

    /**
     * Notification de terminaison d'une formation
     */
    protected function notifyFormationTerminee(int $userId, string $formationTitre): void
    {
        $this->createNotification(
            $userId,
            'formation_terminee',
            "Félicitations ! Vous avez terminé la formation : {$formationTitre}",
            ['formation_titre' => $formationTitre]
        );
    }

    /**
     * Notification de soumission de projet entrepreneurial
     * Notifie l'administrateur
     */
    protected function notifyProjetSoumis(string $projetTitre): void
    {
        $this->notifyAdmin(
            'projet_soumis',
            "Nouveau projet entrepreneurial soumis : {$projetTitre}",
            ['projet_titre' => $projetTitre]
        );
    }

    /**
     * Notification de validation de projet entrepreneurial
     * Notifie l'utilisateur
     */
    protected function notifyProjetValide(int $userId, string $projetTitre): void
    {
        $this->createNotification(
            $userId,
            'projet_valide',
            "Votre projet entrepreneurial '{$projetTitre}' a été validé !",
            ['projet_titre' => $projetTitre]
        );
    }

    /**
     * Notification de rejet de projet entrepreneurial
     * Notifie l'utilisateur
     */
    protected function notifyProjetRejete(int $userId, string $projetTitre, string $motif = ''): void
    {
        $message = "Votre projet entrepreneurial '{$projetTitre}' a été rejeté.";
        if ($motif) {
            $message .= " Motif : {$motif}";
        }

        $this->createNotification(
            $userId,
            'projet_rejete',
            $message,
            ['projet_titre' => $projetTitre, 'motif' => $motif]
        );
    }

    /**
     * Notification de nouveau commentaire dans la communauté
     * Notifie l'auteur du post
     */
    protected function notifyNouveauCommentaire(int $auteurPostId, string $auteurNom, string $postTitre): void
    {
        $this->notifyUser(
            $auteurPostId,
            'nouveau_commentaire',
            "{$auteurNom} a commenté sur votre publication : {$postTitre}",
            ['auteur_nom' => $auteurNom, 'post_titre' => $postTitre]
        );
    }

    /**
     * Notification de nouvelle réponse à un commentaire
     * Notifie l'auteur du commentaire original
     */
    protected function notifyReponseCommentaire(int $auteurCommentaireId, string $auteurNom, string $postTitre): void
    {
        $this->notifyUser(
            $auteurCommentaireId,
            'reponse_commentaire',
            "{$auteurNom} a répondu à votre commentaire sur : {$postTitre}",
            ['auteur_nom' => $auteurNom, 'post_titre' => $postTitre]
        );
    }
}
