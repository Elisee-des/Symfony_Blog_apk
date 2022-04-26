<?php

// namespace App\DataFixtures;

// use App\Entity\Categories;
// use Doctrine\Bundle\FixturesBundle\Fixture;
// use Doctrine\Persistence\ObjectManager;

// class AppFixtures extends Fixture
// {
//     public function load(ObjectManager $manager): void
//     {
//         $categories = [
//             1 => [
//                 'name' => 'Vehicule'
//             ],
//             2 => [
//                 'name' => 'Automobile'
//             ],
//             3 => [
//                 'name' => 'Developpement'
//             ],
//             4 => [
//                 'name' => 'Digital'
//             ],
//         ];

//         fore($categories as $key => $value) {

//             $categorie = new Categories();
//             $categorie->setName($value["name"]);
//             $manager->persist($categorie);
//         };

//         $manager->flush();
//     }

