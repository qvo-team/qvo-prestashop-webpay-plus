CREATE TABLE IF NOT EXISTS `PREFIX_qvo_gateways` (
        `id_qvogateway` int(11) NOT NULL AUTO_INCREMENT,
        `id_cart` int (11) NOT NULL,
        `amount`  int (11)  NOT NULL,
        `redirect_url` Varchar (255)  NOT NULL,
        `transaction_id` Varchar (255)  NOT NULL,
        `status` Varchar (64)  NOT NULL,
        `response` text  NULL,
        `date_add` datetime NOT NULL,
        `date_upd` timestamp NOT NULL DEFAULT NOW(),
         PRIMARY KEY (`id_qvogateway`) )
        ENGINE =InnoDB DEFAULT Charset =utf8 AUTO_INCREMENT=1 ;