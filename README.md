# Faker-Bundle-symfony2
 Faker is a PHP library that generates fake data for you
 
# AppKarnel.php : Config 

 public function registerBundles()
    {
        $bundles = array(
        ...
        );
        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
        ...
          $bundles[] = new Administration\FakerBundle\FakerBundle(); 
        }
         return $bundles;
    }
    
# Routing config:  

faker:
    resource: "@FakerBundle/Resources/config/routing.yml"
    prefix:   /
    
# How to use :  

Pour appeler le service de Faker library :
   
   /** @var  $faker */
   $faker = $this->getContainer()->get('faker.generator');
   
   /** Use Exemple */
   $faker->unique()->randomNumber(3) ; 
   $faker->numberBetween($min = 0, $max = 5)
   $faker->Longitude
   $faker->streetAddress
   ... 
