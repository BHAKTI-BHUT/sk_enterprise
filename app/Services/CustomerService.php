<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\CustomerRepository;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getAll()
    {
        return $this->customerRepository->getAll();
    }

    public function store(array $data)
    {
        return $this->customerRepository->store($data);
    }

    public function update(Customer $customer, array $data)
    {
        return $this->customerRepository->update($customer, $data);
    }

    public function delete(Customer $customer)
    {
        return $this->customerRepository->delete($customer);
    }

    public function findById($id)
    {
        return $this->customerRepository->findById($id);
    }

    public function getAllLedgers()
    {
        return $this->customerRepository->getAllLedgers();
    }
}
