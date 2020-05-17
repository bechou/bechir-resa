<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchToDateTimeTransformer implements DataTransformerInterface {

    //DateTime vers Date FR
    public function transform($date)
    {
        if($date === null)
        {
            return '';
        }

        return $date->format('d/m/Y');
    }

    //Date FR vers DateTime
    public function reverseTransform($frenchDate)
    {
        if($frenchDate === null)
        {
            throw new TransformationFailedException("Fournir une date");
        }

        $date = \DateTime::createFromFormat('d/m/Y', $frenchDate);

        if($date === false)
        {
            throw new TransformationFailedException("Format non valide");
        }

        return $date;

    }

}