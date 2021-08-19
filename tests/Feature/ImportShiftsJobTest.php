<?php

namespace Tests\Feature;

use App\Jobs\ImportShiftsJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ImportShiftsJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_import_shifts_job_working_coorectly()
    {
        $array = json_decode(File::get(public_path('data.json')), true);
        $data = collect($array['shifts'])->chunk(1000)[0];
        $job = new ImportShiftsJob($data);
        $job->handle();
        $this->assertDatabaseCount('shifts', $data->count());
    }

    public function test_empty_whole_data_route_working_correctly()
    {
        // first import some data to database
        $array = json_decode(File::get(public_path('data.json')), true);
        $data = collect($array['shifts'])->chunk(100)[0];
        $job = new ImportShiftsJob($data);
        $job->handle();
        // then test if the route is working correctly
        $response = $this->delete(route('app.emptyData'));
        $response->assertStatus(200);
        $this->assertDatabaseCount('shifts', 0);
    }

    public function test_Store_Shifts_Route_Working_Correctly()
    {
        $array = json_decode(File::get(public_path('data.json')), true);
        $data = collect($array['shifts'])->chunk(2500)[0];
        $response = $this->postJson(route('shifts.store'), [
            'shifts' => $data
        ])
            ->assertStatus(202);
    }

    public function test_index_api_return_expected_data_coorectly()
    {
        $array = json_decode(File::get(public_path('data.json')), true);
        $data = collect($array['shifts'])->chunk(1000)[0];
        $job = new ImportShiftsJob($data);
        $job->handle();
        $response = $this->get(route('shifts.index', [
            'location' => "Braxton Gardens",
            'start' => '2018-01-02T09:00:00+00:00',
            'end' => '2018-01-02T17:00:00+00:00'
        ]));


        $response->assertJsonStructure([
            'data' => [
                [
                    'location', 'type'
                ]
            ]
        ])->status(200);
    }
}
