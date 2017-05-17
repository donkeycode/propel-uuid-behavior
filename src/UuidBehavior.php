<?php

namespace DonkeyCode\Propel\Behavior\Uuid;

use Propel\Generator\Model\Behavior;
use Propel\Runtime\Exception\LogicException;
use Propel\Generator\Model\Unique;

/**
 * @author Cedric LOMBARDOT
 */
class UuidBehavior extends Behavior
{
    /**
     * Default uuid column name
     */
    const DEFAULT_UUID_COLUMN = 'uuid';
    
    private $objectBuilderModifier;

    /**
     * @var array
     */
    protected $parameters = array(
        'uuid_column'     => self::DEFAULT_UUID_COLUMN,
    );

    /**
     * {@inheritdoc}
     */
    public function modifyTable()
    {
        if (!$this->getTable()->hasColumn($this->getParameter('uuid_column'))) {
            $column = array(
                'name'          => $this->getParameter('uuid_column'),
                'type'          => 'CHAR',
                'size'          => 36,
                'required'      => true
            );

            $this->getTable()->addColumn($column);

            $column = $this->getTable()->getColumn($this->getParameter('uuid_column'));
            $unique = new Unique();
            $unique->setName($this->getParameter('uuid_column') . '_uuid_unique');
            $unique->addColumn($column);
            $this->getTable()->addUnique($unique);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectBuilderModifier()
    {
        if (null === $this->objectBuilderModifier) {
            $this->objectBuilderModifier = new UuidObjectBuilderModifier($this);
        }

        return $this->objectBuilderModifier;
    }
}