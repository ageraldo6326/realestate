<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserPhotoUrlTest extends TestCase
{
    public function test_it_resolves_empty_and_legacy_user_photos_to_the_user_default_asset(): void
    {
        $expectedUrl = asset('assets/usuario/default.webp');

        $this->assertSame($expectedUrl, (new User())->resolvePhotoUrl());
        $this->assertSame($expectedUrl, (new User(['foto' => 'default.webp']))->resolvePhotoUrl());
        $this->assertSame($expectedUrl, User::defaultPhotoUrl());
    }

    public function test_it_preserves_existing_user_photo_paths_and_external_urls(): void
    {
        $this->assertSame(
            asset('assets/usuario/perfil.webp'),
            (new User(['foto' => 'usuario/perfil.webp']))->resolvePhotoUrl()
        );
        $this->assertSame(
            'https://images.example.test/perfil.webp',
            (new User(['foto' => 'https://images.example.test/perfil.webp']))->resolvePhotoUrl()
        );
    }
}
