<?php
namespace Mangocube;

/**
 * Generic storage class helps to manage global data.
 *
 */
class Mangocube_Registry extends ArrayObject
{
    /**
     * Class name of the singleton registry object.
     * @var string
     */
    private static $_registryClassName = 'Mangocube_Registry';

    /**
     * Registry object provides storage for shared objects.
     * @var Mangocube_Registry
     */
    private static $_registry = null;

    /**
     * Retrieves the default registry instance.
     *
     * @return Mangocube_Registry
     */
    public static function getInstance()
    {
        if (self::$_registry === null) {
            self::init();
        }

        return self::$_registry;
    }

    /**
     * Set the default registry instance to a specified instance.
     *
     * @param Zend_Registry $registry An object instance of type Zend_Registry,
     *   or a subclass.
     * @return void
     * @throws Zend_Exception if registry is already initialized.
     */
    public static function setInstance(Zend_Registry $registry)
    {
        if (self::$_registry !== null) {
          
            throw new Exception('Registry is already initialized');
        }

        self::setClassName(get_class($registry));
        self::$_registry = $registry;
    }

    /**
     * Initialize the default registry instance.
     *
     * @return void
     */
    protected static function init()
    {
        self::setInstance(new self::$_registryClassName());
    }

    /**
    
     * @param string $registryClassName
     * @return void
     * @throws Mangocube_Registry if the registry is initialized or if the
     *   class name is not valid.
     */
    public static function setClassName($registryClassName = 'Zend_Registry')
    {
        if (self::$_registry !== null) {
           
            throw new Exception('Registry is already initialized');
        }

        if (!is_string($registryClassName)) {
           
            throw new Exception("Argument is not a class name");
        }

        /**
         * @see Mangocube_Registry
         */
        if (!class_exists($registryClassName)) {
          
            Zend_Loader::loadClass($registryClassName);
        }

        self::$_registryClassName = $registryClassName;
    }

    /**
     * Unset the default registry instance.
     * Primarily used in tearDown() in unit tests.
     * @returns void
     */
    public static function _unsetInstance()
    {
        self::$_registry = null;
    }

    /**
     *
     * @param string $index - get the value associated with $index
     * @return mixed
     * @throws Mangocube_Registry if no entry is registered for $index.
     */
    public static function get($index)
    {
        $instance = self::getInstance();

        if (!$instance->offsetExists($index)) {
           
            throw new Exception("No entry is registered for key '$index'");
        }

        return $instance->offsetGet($index);
    }

    /**
     * setter method, basically same as offsetSet().
     *
     * This method can be called from an object of type Zend_Registry, or it
     * can be called statically.  In the latter case, it uses the default
     * static instance stored in the class.
     *
     * @param string $index The location in the ArrayObject in which to store
     *   the value.
     * @param mixed $value The object to store in the ArrayObject.
     * @return void
     */
    public static function set($index, $value)
    {
        $instance = self::getInstance();
        $instance->offsetSet($index, $value);
    }

    /**
     * Returns TRUE if the $index is a named value in the registry,
     * or FALSE if $index was not found in the registry.
     *
     * @param  string $index
     * @return boolean
     */
    public static function isRegistered($index)
    {
        if (self::$_registry === null) {
            return false;
        }
        return self::$_registry->offsetExists($index);
    }

    /**
     * Constructs a parent ArrayObject with default
     * ARRAY_AS_PROPS to allow acces as an object
     *
     * @param array $array data array
     * @param integer $flags ArrayObject flags
     */
    public function __construct($array = array(), $flags = parent::ARRAY_AS_PROPS)
    {
        parent::__construct($array, $flags);
    }

    /**
     * @param string $index
     * @returns mixed
     *
     * Workaround for http://bugs.php.net/bug.php?id=40442 (ZF-960).
     */
    public function offsetExists($index)
    {
        return array_key_exists($index, $this);
    }

}