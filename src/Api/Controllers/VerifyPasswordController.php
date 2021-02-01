<?php
namespace Kyrne\Shout\Api\Controllers; use Flarum\Api\Controller\AbstractShowController; use Flarum\Api\Serializer\BasicUserSerializer; use Flarum\Settings\SettingsRepositoryInterface; use Flarum\User\Exception\PermissionDeniedException; use Kyrne\Shout\Encryption; use Psr\Http\Message\ServerRequestInterface; use Tobscure\JsonApi\Document; use Illuminate\Contracts\Hashing\Hasher; class VerifyPasswordController extends AbstractShowController { public $serializer = BasicUserSerializer::class; protected function data(ServerRequestInterface $spc1c877, Document $spb8026c) { $spd4bab0 = $spc1c877->getAttribute('actor'); $sp2b7469 = $spc1c877->getParsedBody(); if ((bool) app(SettingsRepositoryInterface::class)->get('kyrne-shout.set_own_password')) { $sp18e082 = Encryption::where('user_id', $spd4bab0->id)->first(); if ($sp18e082) { if (app(Hasher::class)->check($sp2b7469['password'], $sp18e082->key)) { return $spd4bab0; } else { throw new PermissionDeniedException(); } } } else { if (!$spd4bab0->checkPassword($sp2b7469['password'])) { throw new PermissionDeniedException(); } else { return $spd4bab0; } } } }