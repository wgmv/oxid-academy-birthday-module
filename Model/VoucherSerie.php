<?php


namespace OxidAcademy\Birthday\Model;


use OxidEsales\Eshop\Application\Model\Voucher;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;

if(false) {
    class_alias(\OxidEsales\Eshop\Application\Model\VoucherSerie::class, 'OxidAcademy\Birthday\Model\VoucherSerie_parent');
}

class VoucherSerie extends VoucherSerie_parent
{
    /**
     * @param User $user
     * @return bool|mixed
     * @throws \Exception
     */
    public function getBirthdayVoucherCode(User $user)
    {
        $voucher = $this->getVoucherFromDb($user);

        if($voucher) {
            return ( ! $this->isVoucherUsed($voucher)) ? $voucher->getFieldData('oxvouchernr') : false;
        }

        $voucher = $this->generateBirthdayVoucher($user);

        return ($voucher && ! $this->isVoucherUsed($voucher)) ? $voucher->getFieldData('oxvouchernr') : false;
    }

    /**
     * @param User $user
     * @return Voucher|null
     * @throws \Exception
     */
    private function generateBirthdayVoucher(User $user)
    {
        $birthdayObj = $this->getBirthdayObj($user);
        $voucherCode = $user->getFieldData('oxfname')
                    . '_' . $birthdayObj->format('m-d')
                    . '_' . substr(Registry::getUtilsObject()->generateUId(), 0, 8);

//        $logger = Registry::getLogger();
//        $logger->info($this->load(Registry::getConfig()->getConfigParam('oaVoucherSeriesId')));
        if($this->load(Registry::getConfig()->getConfigParam('oaVoucherSeriesId'))) {
            $newVoucher = oxNew(Voucher::class);
            $newVoucher->oxvouchers__oxvoucherserieid = new Field($this->getId());
            $newVoucher->oxvouchers__oxvouchernr = new Field($voucherCode);
            $newVoucher->oxvouchers__oxdateused = new Field('0000-00-00');
            $newVoucher->oxvouchers__oa_birthdayvoucher_date = new Field(date('Y') . "-" . $birthdayObj->format('m-d'));
            $newVoucher->oxvouchers__oa_birthdayvoucher_userid = new Field($user->getId());

            return $newVoucher->save() ? $newVoucher : null;
        }
        return null;
    }

    private function isVoucherUsed(Voucher $voucher) : bool
    {
        return $voucher->getFieldData('oxdateused') !== '0000-00-00';
    }

    /**
     * @param User $user
     * @return bool|Voucher
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    private function getVoucherFromDb(User $user)
    {
        $birthdayObj = $this->getBirthdayObj($user);

        $db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
        $sql = "SELECT `oxid` 
                FROM `oxvouchers` 
                WHERE `oa_birthdayvoucher_userid` = " . $db->quote($user->getId()) . "
                AND  `oa_birthdayvoucher_date` = " . $db->quote(date('Y') . "-" . $birthdayObj->format('m-d'));

        $voucherId = $db->getOne($sql);
//        $logger = Registry::getLogger();
//        $logger->info($voucherId);
        $voucher = oxNew(Voucher::class);

        return ($voucherId && $voucher->load($voucherId)) ? $voucher : false;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    private function getBirthdayObj(User $user) : \DateTimeImmutable
    {
        return new \DateTimeImmutable($user->getFieldData('oxbirthdate'));
    }

}