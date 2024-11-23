<?php

// src/Form/Model/ExamFormModel.php
namespace App\Form\Model;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ExamFormModel
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public string $examName;

    #[Assert\NotBlank]
    #[Assert\Type(\DateTime::class)] // Vérifie qu'il s'agit bien d'un objet DateTime
    public ?DateTime $date = null;

    #[Assert\NotBlank]
    #[Assert\File(
        mimeTypes: ["text/csv", "text/plain", "text/tab-separated-values"],
        mimeTypesMessage: "Please upload a valid CSV or TSV file."
    )]
    public ?UploadedFile $file = null;
}