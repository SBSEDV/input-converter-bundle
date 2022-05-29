<?php declare(strict_types=1);

namespace SBSEDV\Bundle\InputConverterBundle\EventSubscriber;

use SBSEDV\Component\InputConverter\Exception\MalformedContentException;
use SBSEDV\Component\InputConverter\Exception\UnsupportedRequestException;
use SBSEDV\Component\InputConverter\InputConverter;
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
            $parsedInput->applyOnHttpFoundationRequest($request);
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
            RequestEvent::class => ['onKernelRequest', 4096],
        ];
    }
}
