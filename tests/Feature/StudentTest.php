<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\Concerns\AssertDatabaseMissing;
use Tests\TestCase;
use App\Models\Student;
use App\Models\User;
use Spatie\Permission\Models\Role;

class StudentTest extends TestCase
{
    //Reset the database before each test
    use RefreshDatabase; 

    public function test_student_create_requires_authentication()
    {
        $response = $this->post('/students', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'dob' => '2000-01-01',
        ]);

        $response->assertRedirect(route('auth.login'));
    }

    public function test_student_create_requires_permission()
    {
        $this->signInWithPermissions([]);
        $response = $this->post('/students', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'dob' => '2000-01-01',
        ]);

        $response->assertStatus(403);
        $response->assertForbidden();

        $this->assertDatabaseMissing('students', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
    }

    public function test_student_can_be_created()
    {
        $user = $this->signInWithPermissions(['create-student']);
        $response = $this->actingAs($user)->post('/students', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'dob' => '2000-01-01',
        ]);
        $response->assertSessionHasNoErrors();
        #$response->assertRedirect(route('student.show', ['student' => Student::first()]));

        $this->assertDatabaseHas('students', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ]);
    }

    public function test_student_archieve_soft_deletes_the_student(): void
    {
        $this->signInWithPermissions(['students.delete']);

        Role::create(['name' => 'student']);

        $user = User::factory()->create();
        $user->assignRole('student');
        $user->student()->create([
            'name' => $user->name,
            'email' => $user->email,
            'dob' => '2000-01-01',
        ]);
        $student = $user->student;

        $response = $this->delete(route('student.archieve', $student));

        $response->assertRedirect(route('student.index'));

        $this->assertSoftDeleted('students', [
            'id' => $student->id,
        ]);
    }
}
