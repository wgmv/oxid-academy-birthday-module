[{$smarty.block.parent}]
[{if $oxcmp_user}]
    [{if $oxcmp_user->hasBirthday()}]
        [{assign var=conf value=$oView->getConfig()}]
        [{assign var=voucher value=$oxcmp_user->getBirthdayVoucherCode()}]
        [{$conf->getConfigParam('blOaBirthdayWishes')}]
        [{if $voucher }]
            Your Voucher:
            <strong>[{$voucher}]</strong>
        [{/if}]
    [{/if}]
[{/if}]