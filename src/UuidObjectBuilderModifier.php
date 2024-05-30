<?php

namespace DonkeyCode\Propel\Behavior\Uuid;

class UuidObjectBuilderModifier
{
    /**
     * @var UuidBehavior
     */
    private $behavior;
    
    public function __construct(\Propel\Generator\Model\Behavior $behavior)
    {
        $this->behavior = $behavior;
    }

    public function preInsert($builder)
    {
        return $this->behavior->renderTemplate('objectPreInsert', array(
            'uuidColumn'            => $this->behavior->getTable()->getColumn($this->behavior->getParameter('uuid_column'))->getConstantName(),
            'uuidColumnSetter'      => $this->getColumnSetter('uuid_column'),
            'uuidColumnGetter'      => $this->getColumnGetter('uuid_column'),
            'version'               => 4,
        ), '../templates/');
    }

    protected function getColumnSetter($columnName)
    {
        return 'set' . $this->behavior->getColumnForParameter($columnName)->getPhpName();
    }

    protected function getColumnGetter($columnName)
    {
        return 'get' . $this->behavior->getColumnForParameter($columnName)->getPhpName();
    }

}
