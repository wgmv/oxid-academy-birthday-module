<?php


namespace OxidAcademy\Birthday\Model;

class_alias(\OxidEsales\Eshop\Application\Model\Voucher::class, 'OxidAcademy\Birthday\Model\Voucher_parent');

class Voucher extends Voucher_parent
{
    public function isBirthdayVoucher()
    {
        return $this->getFieldData('oa_birthdayvoucher_date') != null && $this->getFieldData('oa_birthdayvoucher_date') != '0000-00-00';
    }
}