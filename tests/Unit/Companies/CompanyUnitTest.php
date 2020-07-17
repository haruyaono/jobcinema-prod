<?php

namespace Tests\Unit\Companies;

use App\Job\Employers\Employer;
use App\Job\Companies\Company;
use App\Job\Companies\Exceptions\CreateCompanyErrorException;
use App\Job\Companies\Exceptions\CompanyNotFoundException;
use App\Job\Companies\Repositories\CompanyRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CompanyUnitTest extends TestCase 
{
     /** @test */
     public function it_errors_when_the_company_is_not_found()
     {
         $this->expectException(CompanyNotFoundException::class);
 
         $company = new CompanyRepository(new Company);
         $company->findCompanyById(999);
     }

     /** @test */
    public function it_errors_when_creating_a_company()
    {
        $this->expectException(CreateCompanyErrorException::class);

        $company = new CompanyRepository(new Company);
        $company->createCompany([]);
    }

     /** @test */
     public function it_can_list_all_the_companies()
     {
         $companyRepo = new CompanyRepository(new Company);
         $companies = $companyRepo->listCompanies();
 
         $this->assertGreaterThan(0, $companies->count());
     }

     /** @test */
     public function it_can_update_the_company()
     {

        $company = factory(Company::class)->create();

        $data = [
            'cname' => $this->faker->company,
            'postcode' => $this->faker->postcode,
        ];

        $companyRepo = new CompanyRepository($company);
        $updated = $companyRepo->updateCompany($data);

        $company = $companyRepo->findCompanyById($company->id);

        $this->assertTrue($updated);
        $this->assertEquals($data['cname'], $company->cname);
        $this->assertEquals($data['postcode'], $company->postcode);
     }

     /** @test */
     public function it_can_soft_delete_the_company()
     {
        $created = factory(Company::class)->create();

        $company = new CompanyRepository($created);
        $company->deleteCompany();

        $this->assertDatabaseHas('companies', ['id' => $created->id]);
     }

    /** @test */
    public function it_can_create_the_company()
    {
        $employer = factory(Employer::class)->create();

        $data = [
            'employer_id' => $employer->id,
            'cname' => $this->faker->company,
            'postcode' => $this->faker->postcode,
        ];

        $companyRepo = new CompanyRepository(new Company);
        $company = $companyRepo->createCompany($data);

        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals($data['cname'], $company->cname);
        $this->assertEquals($data['postcode'], $company->postcode);
    }

}
