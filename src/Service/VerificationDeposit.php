<?php

namespace App\Service;

use App\Entity\Deposit;

class VerificationDeposit
{
    public function depositIsValid(Deposit $deposit){

        $somme = 0;
        // on recupere les factures d'acompte liées au devis
        $depositsQuotation = $deposit->getQuotation()->getDeposits();
        foreach ($depositsQuotation as $depositQuotation){
            if($depositQuotation !== $deposit){ // si la facture d'acompte est differente de celle qu on veut créer
                if($depositQuotation->getTvaNonApplicable() === false){ // si tva est applicable on calcule le ht
                   $somme += $depositQuotation->calculMontant();
                } else{ // sinon on prend directement le montant sans tva appliquée
                   $somme += $depositQuotation->getMontantPayer();
                }
            }
        }

        // on verifier si le ht de la facture d'acompte <= la somme des ht des autres factures d'acompte liées à notre devis

        if($deposit->getTvaNonApplicable() === false){
            return $deposit->getQuotation()->calculTotalHt() - $somme >= $deposit->calculMontant();
        }else{
            return $deposit->getQuotation()->calculTotalHt() - $somme >= $deposit->getMontantPayer();
        }


    }

    public function calculReste(Deposit $deposit){
        $somme = 0;

        $depositsQuotation = $deposit->getQuotation()->getDeposits();
        foreach ($depositsQuotation as $depositQuotation){
            if($depositQuotation !== $deposit){
                if($depositQuotation->getTvaNonApplicable() === false){
                    $somme += $depositQuotation->calculMontant();
                } else{
                    $somme += $depositQuotation->getMontantPayer();
                }
            }
        }

        return $deposit->getQuotation()->calculTotalHt() - $somme;
    }

}