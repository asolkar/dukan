INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Purchase without account', 'PURCHASE_WITHOUT_ACCOUNT', 'yes', 'Do you allow customers to purchase without an account?', '5', '10', 'tep_cfg_select_option(array(\'yes\', \'no\'), ', now());
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) VALUES ('Purchase without account shippingaddress', 'PURCHASE_WITHOUT_ACCOUNT_SEPARATE_SHIPPING', 'yes', 'Do you allow customers without account to create separately shipping address?', '5', '11', 'tep_cfg_select_option(array(\'yes\', \'no\'), ', now());
