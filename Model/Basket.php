<?php


namespace OxidAcademy\Birthday\Model;

use OxidEsales\Eshop\Application\Model\Voucher;
use OxidEsales\Eshop\Core\Registry;

class_alias(\OxidEsales\Eshop\Application\Model\Basket::class, 'OxidAcademy\Birthday\Model\Basket_parent');


class Basket extends Basket_parent
{
    /**
     * @param string $sVoucherId
     * @throws \Exception
     */
    public function addVoucher($sVoucherId)
    {
        try { // trying to load voucher and apply it

            $voucher = oxNew(Voucher::class);
            if($voucher->getVoucherByNr($sVoucherId)) {
                if ($voucher->isBirthdayVoucher()) {
                    $voucherDate = new \DateTimeImmutable($voucher->getFieldData('oa_birthdayvoucher_date'));

//                    $logger = Registry::getLogger();
//                    $logger->info($voucherDate->format('y-m-d'));
//                    $logger->info((new \DateTimeImmutable())->setTime(0,0)->format('y-m-d'));
                    if($voucherDate != (new \DateTimeImmutable())->setTime(0,0)) {
                        $oEx = oxNew(\OxidEsales\Eshop\Core\Exception\VoucherException::class, 'ERROR_MESSAGE_VOUCHER_NOBIRTHDAY');
                        $oEx->setVoucherNr($voucher->oxvouchers__oxvouchernr->value);
                        throw $oEx;
                    }
                }
            }

            return parent::addVoucher($sVoucherId);

        } catch (\OxidEsales\Eshop\Core\Exception\VoucherException $oEx) {
            // problems adding voucher
            \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay($oEx, false, true);
        }

        $this->onUpdate();
    }
}