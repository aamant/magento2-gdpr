<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 02/06/18
 * Time: 17:53
 */
declare(strict_types=1);

namespace Flurrybox\EnhancedPrivacy\Service\Export;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Flurrybox\EnhancedPrivacy\Helper\Data;

/**
 * Class CustomerDataProcessor
 */
class CustomerDataProcessor implements ProcessorInterface
{
    /**
     * @var \Flurrybox\EnhancedPrivacy\Helper\Data
     */
    private $helperData;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @param \Flurrybox\EnhancedPrivacy\Helper\Data $helperData
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Data $helperData,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->helperData = $helperData;
        $this->customerRepository = $customerRepository;
    }

    /**
     * {@inheritdoc}
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(int $customerId, array $data): array
    {
        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $this->customerRepository->getById($customerId);

        return array_merge_recursive(
            $data,
            ['customer' => $customer->toArray($this->helperData->{/*@todo getAttributesCodesFromConfig*/})]
        );
    }
}
