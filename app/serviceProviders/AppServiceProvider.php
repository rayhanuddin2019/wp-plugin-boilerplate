<?php 

declare(strict_types=1);

namespace Mangocube\serviceProviders;

use MangoCube_Packages\DI\ServiceProvider\AbstractServiceProvider;
use MangoCube_Packages\DI\ServiceProvider\BootableServiceProviderInterface;
use Mangocube\backend\settings\Controller as Some_Service_Controller;
use Mangocube\backend\settings\Settings_Controller as Settings_Controller;
use Mangocube\backend\settings\fields\Text;
use Mangocube\serviceProviders\App\Notice as Mangocube_Notice;
use Mangocube\serviceProviders\App\Checker as Availability_Checker;
use Mangocube\serviceProviders\App\Branch as Branch;

class AppServiceProvider extends AbstractServiceProvider
{
    /**
     * The provides method is a way to let the container
     * know that a service is provided by this service
     * provider. Every service that is registered via
     * this service provider must have an alias added
     * to this array or it will be ignored.
     */
    public function provides(string $id): bool
    {
        $services = [
            'some_key',
            Some_Service_Controller::class,
            Settings_Controller::class,
            Mangocube_Notice::class,
            Availability_Checker::class,
            Branch::class,
            \Mangocube\backend\settings\fields\Text::class,
          
        ];
        
        return in_array($id, $services);
    }

    /**
     * In much the same way, this method has access to the container
     * itself and can interact with it however you wish, the difference
     * is that the boot method is invoked as soon as you register
     * the service provider with the container meaning that everything
     * in this method is eagerly loaded.
     *
     * If you wish to apply inflectors or register further service providers
     * from this one, it must be from a bootable service provider like
     * this one, otherwise they will be ignored.
     */
    public function boot(): void
    {
        
    }

    /**
     * The register method is where you define services
     * in the same way you would directly with the container.
     * A convenience getter for the container is provided, you
     * can invoke any of the methods you would when defining
     * services directly, but remember, any alias added to the
     * container here, when passed to the `provides` nethod
     * must return true, or it will be ignored by the container.
     */
    public function register(): void
    {
     
        $this->getContainer()->add('some_key', 'value');

        $this->getContainer()
            ->add(Some_Service_Controller::class)
             ->addArgument(\Mangocube\backend\settings\fields\Text::class);         
      

         $this->getContainer()->add(Settings_Controller::class);
         
         $this->getContainer()->add(\Mangocube\serviceProviders\App\Notice::class);
         $this->getContainer()->add(\Mangocube\backend\settings\fields\Text::class);
         $this->getContainer()->add(\Mangocube\serviceProviders\App\Checker::class);
         $this->getContainer()->add(\Mangocube\serviceProviders\App\Branch::class);

    }
}
