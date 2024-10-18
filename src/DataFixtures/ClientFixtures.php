<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Client;
use App\Entity\Details;
use App\Entity\Dette;
use App\Entity\EtatArticle;
use App\Entity\EtatDette;
use App\Entity\TypeDette;
use App\Entity\User;
use App\Entity\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder) {
        $this->encoder=$encoder;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <=4 ; $i++) {
            $client=new Client();   
            $client -> setSurname('Surname'.$i);
            $client -> setTelephone('77479947'.$i);
            $client -> setAdresse('Adresse'.$i);
            if ($i % 2 == 0) {
                $user= new User();
                $user -> setNom('Nom'.$i);
                $user -> setPrenom('Prenom'.$i);
                $user -> setLogin('Login'.$i);
                $plaintextPassword = "password";
                $hashedPassword = $this->encoder->hashPassword(
                    $user,
                    $plaintextPassword
                );
                $user->setPassword($hashedPassword);
                $user->setRole($i % 4 == 0 ? UserRole::roleBoutiquier : UserRole::roleClient);
                $client->setUserr($user);
                $manager->persist($user);
                for ($j=1; $j <=2 ; $j++) {
                    $dette=new Dette();
                    $dette->setMontant(2000);
                    $dette->setMontantVerse(500);
                    $dette->setMontantRestant(0);
                    $dette->setType($j % 4 == 0 ? TypeDette::solde : TypeDette::nonSolde);
                    $dette->setEtat($j % 4 == 0 ? EtatDette::enCours : EtatDette::enCours);
                    $client->addDette($dette);
                    $dette->setClient($client);
                    $manager->persist($dette);
                
                    for ($a=1; $a <=2 ; $a++) {
                        $article=new Article();
                        $article->setReference('reference'.$a);
                        $article->setLibelle('libelle'.$a);
                        $article->setQteStock(10);
                        $article->setPrix(500);
                        $article->setEtat($a % 4 == 0 ? EtatArticle::indisponible : EtatArticle::disponible);
                        $manager->persist($article);
                        for ($a=1; $a <=2 ; $a++) {
                            $details=new Details();
                            $details->setQteDette(2);
                            $details->setArticle($article);
                            $details->setDette($dette);
                            $manager->persist($details);
                        }
                    }
                } 
            }else{
                $client->setUserr(null);
                for ($j=1; $j <=2 ; $j++) {
                    $dette=new Dette();
                    $dette->setMontant(2000);
                    $dette->setMontantVerse(1000);
                    $dette->setMontantRestant(0);
                    $dette->setType($j % 4 == 0 ? TypeDette::solde : TypeDette::nonSolde);
                    $dette->setEtat($j % 4 == 0 ? EtatDette::annule : EtatDette::enCours);
                    $client->addDette($dette);
                    $dette->setClient($client);
                } 
           }
            $manager->persist($client);
        }

        $manager->flush();
    }
}
