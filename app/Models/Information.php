<?php
// ============================================================
// app/Models/Information.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Information extends Model
{
    protected $table = 'informations';

    protected $fillable = [
        'auteur_id', 'titre', 'contenu', 'categorie',
        'image_url', 'statut', 'vues',
    ];

    protected $casts = [
        'vues' => 'integer',
    ];

    // ── Relations ────────────────────────────────────────────
    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    public function commentaires(): HasMany
    {
        return $this->hasMany(CommentaireInformation::class, 'information_id');
    }

    public function commentairesApprouves(): HasMany
    {
        return $this->hasMany(CommentaireInformation::class, 'information_id')
                    ->where('statut', 'approuve')
                    ->latest();
    }

    // ── Helpers ───────────────────────────────────────────────
    public static function categories(): array
    {
        return [
            'sante'           => ['label' => 'Santé',            'couleur' => '#E74C3C', 'icone' => 'heart'],
            'droits_justice'  => ['label' => 'Droits & Justice', 'couleur' => '#2980B9', 'icone' => 'scale'],
            'agriculture'     => ['label' => 'Agriculture',      'couleur' => '#27AE60', 'icone' => 'leaf'],
            'education'       => ['label' => 'Éducation',        'couleur' => '#F39C12', 'icone' => 'book'],
            'numerique'       => ['label' => 'Numérique',        'couleur' => '#8E44AD', 'icone' => 'monitor'],
            'annonces_locales'=> ['label' => 'Annonces locales', 'couleur' => '#C9923A', 'icone' => 'megaphone'],
        ];
    }

    public function categorieLabel(): string
    {
        return self::categories()[$this->categorie]['label'] ?? $this->categorie;
    }

    public function categorieCouleur(): string
    {
        $categories = self::categories();
        $categorie = $this->categorie ?? null;

        if ($categorie === null || !isset($categories[$categorie])) {
            return '#888888';
        }

        return $categories[$categorie]['couleur'] ?? '#888888';
    }

    public function incrementerVues(): void
    {
        $this->increment('vues');
    }

    // Extrait court du contenu (sans HTML)
    public function extrait(int $longueur = 160): string
    {
        return Str::limit(strip_tags($this->contenu), $longueur);
    }

    // Scopes
    public function scopePublie($query)
    {
        return $query->where('statut', 'publie');
    }

    public function scopeParCategorie($query, string $categorie)
    {
        return $query->where('categorie', $categorie);
    }
}


// ============================================================
// app/Models/CommentaireInformation.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentaireInformation extends Model
{
    protected $table = 'commentaires_information';

    protected $fillable = [
        'information_id', 'user_id', 'contenu', 'statut',
    ];

    public function information(): BelongsTo
    {
        return $this->belongsTo(Information::class, 'information_id');
    }

    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
