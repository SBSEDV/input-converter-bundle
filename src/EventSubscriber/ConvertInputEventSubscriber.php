<?php declare(strict_types=1);

namespace SBSEDV\Bundle\InputConverterBundle\EventSubscriber;

use SBSEDV\InputConverter\Exception\MalformedContentException;
use SBSEDV\InputConverter\Exception\UnsupportedRequestException;
use SBSEDV\InputConverter\InputConverter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class ConvertInputEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private InputConverter $inputConverter
    ) {
    }

    /**
     * Handle the "kernel.request" event.
     *
     * @param RequestEvent $event The "kernel.request" event.
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        try {
            $parsedInput = $this->inputConverter->convert($request);

            foreach ($parsedInput->getValues() as $key => $value) {
                $request->request->set($key, $value);
            }

            foreach ($parsedInput->getFiles() as $key => $value) {
                $request->files->set($key, $value);
            }

            $request->attributes->set('_input_converter', $parsedInput->getConverterName());
        } catch (MalformedContentException $e) {
            throw new BadRequestException($e->getMessage(), previous: $e);
        } catch (UnsupportedRequestException) {
            // do nothing
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => ['onKernelRequest', \PHP_INT_MAX],
        ];
    }
}
