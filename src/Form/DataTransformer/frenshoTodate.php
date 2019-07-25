<?php
namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;


class frenshoTodate implements DataTransformerInterface
{


    public function transform($date)
    {
        if($date==null)
        {
            return '';
        }
        return $date->format('d/m/Y');
    }
    
    public function reverseTransform($frenshDate)
    {

         if($frenshDate==null)
         {
            throw new TransformationFailedException(
                'Vous devez fournir une date!'
            );
         }

         $date=\DateTime::createFromFormat('d/m/Y',$frenshDate);

         if($date==false)
         {
            throw new TransformationFailedException(
                'Vous devez fournir une date!'
            );
         }

         return $date;
    }

}