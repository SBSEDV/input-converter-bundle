# sbsedv/input-converter-bundle

A [Symfony ^6.1](https://symfony.com/) bundle that adds the raw request body input to the http-foundation InputBag.

---

This bundle integrates [sbsedv/input-converter](https://github.com/SBSEDV/input-converter-php) into the [Symfony Framework](https://symfony.com/).

This bundle registers an event listener that runs as early as possible in the applications lifecycle and tries to parse the incoming request body
and to add it to the main http-foundation request object.

By default this bundle comes with the following converters which are all enabled by default:

```yaml
# config/packages/sbsedv_input_converter.yaml

# Default configuration values are shown

sbsedv_input_converter:
    # {NAME}_converter: false # disables the {NAME} converter

    json_converter:
        content_types: [application/json] # Http Content-Type headers on which this converter will work
        methods: [POST, PUT, PATCH, DELETE] # Http Methods on which this convert will work

    formdata_converter:
        methods: [PUT, PATCH, DELETE]
        file_support: false # Whether file uploads are added to the FileBag

    urlencoded_converter:
        enabled: false # disabled by default, see below
        methods: [PUT, PATCH, DELETE]
```

**WARNING**: You should not enable `file_support` for the `formdata_converter`.

The entire uploaded file would be copied into memory at least two times which will potentially use a lot of system memory (depending on the file size).
PHPs `upload_max_filesize` INI setting has no effect, only `post_max_size`.

You should only rely on PHPs integrated file upload support.

---

## **Custom Converters**

If you want to register a custom converter (e.g. for YAML support), you only have to register a service in your application that implements the `SBSEDV\InputConverter\Converter\ConverterInterface`.

The bundle has autoconfiguration setup and each service that implements that interface will automatically be picked up.

---

## **URLEncodedConverter Information**

By default, the `urlencoded_converter` is disabled because `Symfony\Component\HttpFoundation\Request::createFromGlobals()` has the same functionality.

The vast majority of symfony applications boot up the framework in a way that creates the Request object with this static method.
Because of this, the bundle disables its functionality by default to avoid unneccessary work.

In case you boot symfony without calling this method (e.g. in a runtime like [Swoole](https://github.com/php-runtime/swoole)), you can enable the functionality manually in the bundles config file.
