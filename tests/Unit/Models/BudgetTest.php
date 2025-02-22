<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Budget;
use App\Models\Customer;

class BudgetTest extends TestCase
{
    private Customer $customer;

    public function setUp(): void
    {
        parent::setUp();

        $this->customer = new Customer(
            [
                'name' => 'Customer 1',
                'email' =>  'fulano@example.com',
                'password' =>  '123456',
                'password_confirmation' =>  '123456',
                'phone' =>  '(11) 1 1111-1111',
                'cpf' =>  '111.111.111-11',
                'cnpj' =>  '11.111.111/1111-11'
            ]
        );

        $this->customer->save();
    }

    public function test_should_create_new_budget(): void
    {
        $budget = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 10
            ]
        );

        $this->assertTrue($budget->save());

        $this->assertCount(1, Budget::all());
    }

    public function test_all_should_return_all_budgets(): void
    {
        $budgets[] = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 10
            ]
        );

        $budgets[] = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 20
            ]
        );

        foreach ($budgets as $budget) {
            $budget->save();
        }

        $all = Budget::all();

        $this->assertCount(2, $all);

        $this->assertEquals($budgets, $all);
    }

    public function test_destroy_should_remove_the_budget(): void
    {
        $budget1 = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 10
            ]
        );

        $budget2 = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'completed',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 20
            ]
        );

        $budget1->save();
        $budget2->save();

        $budget2->destroy();

        $this->assertCount(1, Budget::all());
    }

    public function test_set_total(): void
    {
        $budget = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 10
            ]
        );

        $this->assertEquals(10, $budget->total);
    }

    public function test_set_id(): void
    {
        $budget = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 10
            ]
        );

        $budget->id = 7;

        $this->assertEquals(7, $budget->id);
    }

    public function test_errors_should_return_total_error(): void
    {
        $budget = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 10
            ]
        );

        $budget->total = 0;

        $budget->save();

        $this->assertTrue($budget->isValid());
        $this->assertTrue($budget->save());
        $this->assertTrue($budget->hasErrors());
    }

    public function test_find_by_id_should_return_the_budget(): void
    {
        $budget2 = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 20
            ]
        );

        $budget1 = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 10
            ]
        );

        $budget3 = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 30
            ]
        );

        $budget1->save();
        $budget2->save();
        $budget3->save();

        $this->assertEquals($budget1, Budget::findById($budget1->id));
    }

    public function test_find_by_id_should_return_null(): void
    {
        $budget = new Budget(
            [
                'customer_id' => $this->customer->id,
                'status' => 'pending',
                'cancelled' => 0,
                'payed' => 0,
                'total' => 10
            ]
        );

        $budget->save();

        $this->assertNull(Budget::findById(7));
    }
}
