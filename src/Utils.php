<?php
namespace Bandzaai\Threading;

class Utils
{

    /**
     * check if the sub class of Process has overwrite the run method
     *
     * @param
     *            $child_class
     */
    public static function checkOverwriteRunMethod($child_class)
    {
        $parent_class = '\\Bandzaai\\BzThreading\\Process';
        if ($child_class == $parent_class) {
            $message = "you should extend the `{$parent_class}`" . ' and overwrite the run method';
            throw new \RuntimeException($message);
        }
        
        $child = new \ReflectionClass($child_class);
        if ($child->getParentClass() === false) {
            $message = "you should extend the `{$parent_class}`" . ' and overwrite the run method';
            throw new \RuntimeException($message);
        }
        
        $parent_methods = $child->getParentClass()->getMethods(\ReflectionMethod::IS_PUBLIC);
        
        foreach ($parent_methods as $parent_method) {
            if ($parent_method->getName() !== 'run')
                continue;
            
            $declaring_class = $child->getMethod($parent_method->getName())
                ->getDeclaringClass()
                ->getName();
            
            if ($declaring_class === $parent_class) {
                throw new \RuntimeException('you must overwrite the run method');
            }
        }
    }
}