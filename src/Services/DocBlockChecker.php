<?php
// /repo/src/Services/DocBlockChecker.php
namespace Services;
use ReflectionClass;
class DocBlockChecker
{
    public $target = '';    // class to check
    public $reflect = NULL; // ReflectionClass instance
    /**
     * @param string $target : class to be checked
     * @return void
     */
    public function __construct(string $target)
    {
        $this->target = $target;
        $this->reflect = new ReflectionClass($target);
    }
    /**
     * Check methods for docBlocks
     * If one exists but no @param, adds them
     * If no docBlock, creates one
     *
     * @return array $methods : method name => docBlock
     */
    public function check()
    {
        // get methods
        $methods = [];
        $list = $this->reflect->getMethods();
        foreach ($list as $refMeth) {
            // get docbock
            $docBlock = $refMeth->getDocComment();
            if (!$docBlock) {
                $docBlock = "/**\n * " . $refMeth->getName() . "\n";
                // get params
                $params = $refMeth->getParameters();
                if ($params) {
                    foreach ($params as $refParm) {
                        $type = $refParm->getType() ?? 'mixed';
                        $type = (string) $type;
                        $name = $refParm->getName();
                        $default = '';
                        if (!$refParm->isVariadic() && $refParm->isOptional())
                            $default = $refParm->getDefaultValue();
                        if ($default === '') $default = "(empty string)";
                        $docBlock .= " * @param $type \${$name} : $default\n";
                    }
                }
                // get return type
                if ($refMeth->isConstructor())
                    $return = 'void';
                else
                    $return = $refMeth->getReturnType() ?? 'mixed';
                $docBlock .= " * @return $return\n";
                $docBlock .= " */\n";
            }
            $methods[$refMeth->getName()] = $docBlock;
        }
        return $methods;
    }
}
