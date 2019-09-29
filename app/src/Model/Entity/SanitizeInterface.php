<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 21/09/19
 * Time: 15:02
 */

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;

interface SanitizeInterface
{
    /**
     * Formate une chaine de caractère avant un enregistrement en bdd
     * lors d'une création ou d'une mise à jour
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     *
     * @return void
     */
    public function sanitizeFields(): void;

}