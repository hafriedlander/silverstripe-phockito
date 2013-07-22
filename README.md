# Phockito integration module for SilverStripe

Phockito generates subclasses of the class under mock or spy. This doesn't work well with SilverStripe, which builds
a manifest of classes and expects them to remain static during execution.

This module provides integration between SilverStripe and Phockito, so that every time you create a mock or
spy with Phockito, it's registered in SilverStripe's ClassManifest.

This all happens automatically, so you don't have to worry about it - just add this module to your composer.json,
then start calling Phocktio::mock or Phockito::spy in your tests.
