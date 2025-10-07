<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
   //seed the root admin user
        User::firstOrCreate([
            "email" =>"admin@admin.com"],
            [
            "name" =>"Admin",
            "password" =>Hash::make("12345678"),
            "role" => "admin",
            "email_verified_at" => now(),
        ]);


//seed data to test the application
        $jobdata = json_decode(file_get_contents(database_path('data/job_data.json')), true);


        // create job categories
        foreach($jobdata["jobCategories"] as $category){
            JobCategory::firstOrCreate([

                "name" => $category,

            ]);

    }




    //create companies
    foreach($jobdata["companies"] as $company){

        // create company owner
        $companyOwner = User::firstOrCreate([
            "email" =>fake()->unique()->safeEmail()],

            [
            "name" => fake()->name(),
            "password" =>Hash::make("12345678"),
            "role" => "company-owner",
            "email_verified_at" => now(),
        ]);



        Company::firstOrCreate([
        "name" => $company["name"],

            ],[
                "address" => $company["address"],
                "industry" => $company["industry"],
                "website" => $company["website"],
                "ownerid" => $companyOwner->id,

            ]);

    }


    // crate job vacancies
    foreach($jobdata["jobVacancies"] as $job){

        // get the  created company
    $company = Company::where("name", $job["company"])->firstOrFail();


        // get the  created job category
    $jobCategory = JobCategory::where("name", $job["category"])->firstOrFail();




        JobVacancy::firstOrCreate([

            "title" => $job["title"],
            "company_id" => $company->id,
],

            [
            "description" => $job["description"],
            "location" => $job["location"],
            "type" => $job["type"],
            "salary" => $job["salary"],
            "jobcategory_id" => $jobCategory->id,

    ]);





    // create job applications

    if (isset($jobdata["jobApplications"])) {
    foreach($jobdata["jobApplications"] as $application){

        // get the  random  job vacancy
    $jobVacancy= JobVacancy::inRandomOrder()->first();



    // create applicant  (job-seeker user)

    $applicant=User::firstOrCreate([
        "email" => fake()->unique()->safeEmail()],

        [
        "name" => fake()->name(),
        "password" =>Hash::make("12345678"),
        "role" => "job-seeker",
        "email_verified_at" => now(),
    ]);




    // crate resume
    $resume = Resume::create([
    "userid" => $applicant->id,
    "filename" => $application["resume"]["filename"] ?? null,
    "fileurl" => $application["resume"]["fileUri"] ?? null, // <-- burayı düzelttik
    "summary" => $application["resume"]["summary"] ?? null,
    "contactDetails" => $application["resume"]["contactDetails"] ?? null,
    "education" => $application["resume"]["education"] ?? null,
    "experience" => $application["resume"]["experience"] ?? null,
    "skills" => $application["resume"]["skills"] ?? null,
]);


// create job application
JobApplication::create([
    "userid" => $applicant->id,
    "jobvacancyid" => $jobVacancy->id,
    "resumeid" => $resume->id,
    "aigeneratedscore" => $application["aiGeneratedScore"] ?? 0,
    "aigeneratedfeedback" => $application["aiGeneratedFeedback"] ?? null,
]);



    }


}
    }
}
}
