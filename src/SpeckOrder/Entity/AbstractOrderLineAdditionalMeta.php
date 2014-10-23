<?php

namespace SpeckOrder\Entity;

abstract class AbstractOrderLineAdditionalMeta
{
    protected $identifier;

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }
}
