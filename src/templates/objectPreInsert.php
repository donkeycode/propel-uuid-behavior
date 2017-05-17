if (is_null($this-><?php echo $uuidColumnGetter ?>())) {
    $this-><?php echo $uuidColumnSetter ?>(\Ramsey\Uuid\Uuid::uuid<?php echo $version ?>()->__toString());
} else {
    $uuid = $this-><?php echo $uuidColumnGetter ?>();

    if (!\Ramsey\Uuid\Uuid::isValid($uuid)) {
        throw new \InvalidArgumentException('UUID: ' . $uuid . ' in not valid');
    }
}