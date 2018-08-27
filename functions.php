<?php
/**
 * In NOUVEAU, the only thing this file does is load and start the NV core.
 *
 * Yes, that's it. All the magic happens in the NV directory.
 */

// Load NOUVEAU...
require 'NV/Core.php';

// Start NOUVEAU...
\NV\Theme\Core::i();