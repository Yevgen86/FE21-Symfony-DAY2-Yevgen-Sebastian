<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Product;


class ProductController extends AbstractController

{

   

    #[Route("/", name:"indexAction")]

    public function indexAction()

    {

        $products = $this->getDoctrine()

            ->getRepository(Product::class)

            ->findAll();// this variable $products will store the result of running a query to find all the products

        return $this->render('product/index.html.twig',array( "products"=>$products));

// i send the variable that have all the products as an array of objects to the index.html.twig page

    }


    #[Route("/create", name:"createAction")]

    public function createAction()

    {  

       

        // you can fetch the EntityManager via $this->getDoctrine()

        // or you can add an argument to your action: createAction(EntityManagerInterface $em)

        $em = $this->getDoctrine()->getManager();

        $product = new Product(); // here we will create an object from our class Product.

        $product->setName('New Foundland'); // in our Product class we have a set function for each column in our db

        $product->setPrice(2.200);
        $product->setImage('http://cdn.cnn.com/cnnnext/dam/assets/180419121727-01-newfoundland.jpg');
        $product->setDescription('The Newfoundland is a large, strong dog breed from—wait for it—Newfoundland. They were originally used as a working dog to pull nets for fishermen and haul wood from the forest. Theyre a capable and hardworking dog, well suited to work on land or water.');

        // tells Doctrine you want to (eventually) save the Product (no queries yet)

        $em->persist($product);

        // actually executes the queries (i.e. the INSERT query)

        $em->flush();

        return new Response('Saved new product with id ' .$product->getId());

    }


    #[Route("/details/{productId}", name:"detailsAction")]

    public function showdetailsAction($productId)

    {

        $product = $this->getDoctrine()

            ->getRepository(Product::class)

            ->find($productId);

      

           /*  return new Response('Details from the product with id ' .$productId.", Product name is ".$product->getName()." and it cost ".$product->getPrice(). "€" ); */
           return $this->render('product/details.html.twig',array( "product"=>$product));
        

       

    }

}