<?php

namespace Tests\Unit;

use App\Models\Translation;
use App\Models\User;
use Tests\TestCase; 
use Illuminate\Foundation\Testing\RefreshDatabase;

class TranslationApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->token = $this->user->createToken('authToken')->plainTextToken;
    }

    /** @test */
    public function it_requires_authentication_for_translations()
    {
        $response = $this->getJson('/api/translations');
        $response->assertStatus(401); // Unauthorized
    }


    /** @test */
    public function it_can_create_a_translation()
    {
        $translationData = [
            'locale' => 'fr',
            'key' => 'welcome_message',
            'value' => 'Bienvenue sur notre plateforme!',
            'tags' => ['mobile', 'web']
        ];

        $response = $this->postJson('/api/translations', $translationData, $this->authHeaders());

        $response->assertStatus(201)
            ->assertJsonFragment(['key' => 'welcome_message']);
    }

    /** @test */
    public function it_validates_translation_creation()
    {
        $response = $this->postJson('/api/translations', [], $this->authHeaders());

        $response->assertStatus(422) // Unprocessable Entity
        ->assertJsonValidationErrors(['locale', 'key', 'value']);
    }

    /** @test */
    public function it_can_update_a_translation()
    {
        $translation = Translation::factory()->create();

        $updateData = ['value' => 'Updated translation text'];

        $response = $this->putJson("/api/translations/{$translation->id}", $updateData, $this->authHeaders());

        $response->assertStatus(200)
            ->assertJsonFragment(['value' => 'Updated translation text']);
    }

    /** @test */
    public function it_checks_if_translation_exists_before_update()
    {
        $response = $this->putJson('/api/translations/999', ['value' => 'Test'], $this->authHeaders());
        $response->assertStatus(404); // Not Found
    }

    /** @test */
    public function it_can_delete_a_translation()
    {
        $translation = Translation::factory()->create();

        $response = $this->deleteJson("/api/translations/{$translation->id}", [], $this->authHeaders());

        $response->assertStatus(200);
        $this->assertDatabaseMissing('translations', ['id' => $translation->id]);
    }

    /** @test */
    public function it_checks_if_translation_exists_before_delete()
    {
        $response = $this->deleteJson('/api/translations/999', [], $this->authHeaders());
        $response->assertStatus(404); // Not Found
    }

    private function authHeaders()
    {
        return ['Authorization' => 'Bearer ' . $this->token];
    }
}
