<?php
/**
 * Smile PriceRequestor registration
 *
 * @category  Smile
 * @package   Smile\PriceRequestor
 * @author    Tetiana Lebed <teleb@smile.fr>
 * @copyright 2019 Smile
 */
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Smile_PriceRequestor',
    __DIR__
);
