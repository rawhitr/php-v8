/*
  +----------------------------------------------------------------------+
  | This file is part of the pinepain/php-v8 PHP extension.              |
  |                                                                      |
  | Copyright (c) 2015-2016 Bogdan Padalko <pinepain@gmail.com>          |
  |                                                                      |
  | Licensed under the MIT license: http://opensource.org/licenses/MIT   |
  |                                                                      |
  | For the full copyright and license information, please view the      |
  | LICENSE file that was distributed with this source or visit          |
  | http://opensource.org/licenses/MIT                                   |
  +----------------------------------------------------------------------+
*/

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php_v8_heap_statistics.h"
#include "php_v8_value.h"
#include "php_v8.h"

zend_class_entry *php_v8_heap_statistics_class_entry;
#define this_ce php_v8_heap_statistics_class_entry


void php_v8_heap_statistics_create_from_heap_statistics(zval *return_value, v8::HeapStatistics *hs) {
    assert(NULL != hs);

    object_init_ex(return_value, this_ce);

    zend_update_property_double(this_ce, return_value, ZEND_STRL("total_heap_size"), hs->total_heap_size());
    zend_update_property_double(this_ce, return_value, ZEND_STRL("total_heap_size_executable"), hs->total_heap_size_executable());
    zend_update_property_double(this_ce, return_value, ZEND_STRL("total_physical_size"), hs->total_physical_size());
    zend_update_property_double(this_ce, return_value, ZEND_STRL("total_available_size"), hs->total_available_size());
    zend_update_property_double(this_ce, return_value, ZEND_STRL("used_heap_size"), hs->used_heap_size());
    zend_update_property_double(this_ce, return_value, ZEND_STRL("heap_size_limit"), hs->heap_size_limit());

    zend_update_property_bool(this_ce, return_value, ZEND_STRL("does_zap_garbage"), static_cast<zend_long>(hs->does_zap_garbage()));

}

static PHP_METHOD(V8HeapStatistics, __construct) {
    double total_heap_size = 0;
    double total_heap_size_executable = 0;
    double total_physical_size = 0;
    double total_available_size = 0;
    double used_heap_size = 0;
    double heap_size_limit = 0;

    zend_bool does_zap_garbage = '\0';

    if (zend_parse_parameters(ZEND_NUM_ARGS(), "|ddddddb",
                              &total_heap_size, &total_heap_size_executable, &total_physical_size, &total_available_size,
                              &used_heap_size, &heap_size_limit, &does_zap_garbage) == FAILURE) {
        return;
    }

    zend_update_property_double(this_ce, getThis(), ZEND_STRL("total_heap_size"), total_heap_size);
    zend_update_property_double(this_ce, getThis(), ZEND_STRL("total_heap_size_executable"), total_heap_size_executable);
    zend_update_property_double(this_ce, getThis(), ZEND_STRL("total_physical_size"), total_physical_size);
    zend_update_property_double(this_ce, getThis(), ZEND_STRL("total_available_size"), total_available_size);
    zend_update_property_double(this_ce, getThis(), ZEND_STRL("used_heap_size"), used_heap_size);
    zend_update_property_double(this_ce, getThis(), ZEND_STRL("heap_size_limit"), heap_size_limit);

    zend_update_property_bool(this_ce, getThis(), ZEND_STRL("does_zap_garbage"), does_zap_garbage);
}

static PHP_METHOD(V8HeapStatistics, total_heap_size) {
    zval rv;

    if (zend_parse_parameters_none() == FAILURE) {
        return;
    }

    RETVAL_ZVAL(zend_read_property(this_ce, getThis(), ZEND_STRL("total_heap_size"), 0, &rv), 1, 0);
}

static PHP_METHOD(V8HeapStatistics, total_heap_size_executable) {
    zval rv;

    if (zend_parse_parameters_none() == FAILURE) {
        return;
    }

    RETVAL_ZVAL(zend_read_property(this_ce, getThis(), ZEND_STRL("total_heap_size_executable"), 0, &rv), 1, 0);
}

static PHP_METHOD(V8HeapStatistics, total_physical_size) {
    zval rv;

    if (zend_parse_parameters_none() == FAILURE) {
        return;
    }

    RETVAL_ZVAL(zend_read_property(this_ce, getThis(), ZEND_STRL("total_physical_size"), 0, &rv), 1, 0);
}

static PHP_METHOD(V8HeapStatistics, total_available_size) {
    zval rv;

    if (zend_parse_parameters_none() == FAILURE) {
        return;
    }

    RETVAL_ZVAL(zend_read_property(this_ce, getThis(), ZEND_STRL("total_available_size"), 0, &rv), 1, 0);
}

static PHP_METHOD(V8HeapStatistics, used_heap_size) {
    zval rv;

    if (zend_parse_parameters_none() == FAILURE) {
        return;
    }

    RETVAL_ZVAL(zend_read_property(this_ce, getThis(), ZEND_STRL("used_heap_size"), 0, &rv), 1, 0);
}

static PHP_METHOD(V8HeapStatistics, heap_size_limit) {
    zval rv;

    if (zend_parse_parameters_none() == FAILURE) {
        return;
    }

    RETVAL_ZVAL(zend_read_property(this_ce, getThis(), ZEND_STRL("heap_size_limit"), 0, &rv), 1, 0);
}

static PHP_METHOD(V8HeapStatistics, does_zap_garbage) {
    zval rv;

    if (zend_parse_parameters_none() == FAILURE) {
        return;
    }

    RETVAL_ZVAL(zend_read_property(this_ce, getThis(), ZEND_STRL("does_zap_garbage"), 0, &rv), 1, 0);
}


ZEND_BEGIN_ARG_INFO_EX(arginfo_v8_heap_statistics___construct, ZEND_SEND_BY_VAL, ZEND_RETURN_VALUE, 0)
                ZEND_ARG_TYPE_INFO(0, total_heap_size, IS_DOUBLE, 0)
                ZEND_ARG_TYPE_INFO(0, total_heap_size_executable, IS_DOUBLE, 0)
                ZEND_ARG_TYPE_INFO(0, total_physical_size, IS_DOUBLE, 0)
                ZEND_ARG_TYPE_INFO(0, total_available_size, IS_DOUBLE, 0)
                ZEND_ARG_TYPE_INFO(0, used_heap_size, IS_DOUBLE, 0)
                ZEND_ARG_TYPE_INFO(0, heap_size_limit, IS_DOUBLE, 0)
                ZEND_ARG_TYPE_INFO(0, does_zap_garbage, _IS_BOOL, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_v8_heap_statistics__total_heap_size, ZEND_RETURN_VALUE, 0, IS_DOUBLE, NULL, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_v8_heap_statistics__total_heap_size_executable, ZEND_RETURN_VALUE, 0, IS_DOUBLE, NULL, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_v8_heap_statistics__total_physical_size, ZEND_RETURN_VALUE, 0, IS_DOUBLE, NULL, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_v8_heap_statistics__total_available_size, ZEND_RETURN_VALUE, 0, IS_DOUBLE, NULL, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_v8_heap_statistics__used_heap_size, ZEND_RETURN_VALUE, 0, IS_DOUBLE, NULL, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_v8_heap_statistics__heap_size_limit, ZEND_RETURN_VALUE, 0, IS_DOUBLE, NULL, 0)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_v8_heap_statistics__does_zap_garbage, ZEND_RETURN_VALUE, 0, _IS_BOOL, NULL, 0)
ZEND_END_ARG_INFO()


static const zend_function_entry php_v8_heap_statistics_methods[] = {
        PHP_ME(V8HeapStatistics, __construct, arginfo_v8_heap_statistics___construct, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)

        PHP_ME(V8HeapStatistics, total_heap_size, arginfo_v8_heap_statistics__total_heap_size, ZEND_ACC_PUBLIC)
        PHP_ME(V8HeapStatistics, total_heap_size_executable, arginfo_v8_heap_statistics__total_heap_size_executable, ZEND_ACC_PUBLIC)
        PHP_ME(V8HeapStatistics, total_physical_size, arginfo_v8_heap_statistics__total_physical_size, ZEND_ACC_PUBLIC)
        PHP_ME(V8HeapStatistics, total_available_size, arginfo_v8_heap_statistics__total_available_size, ZEND_ACC_PUBLIC)
        PHP_ME(V8HeapStatistics, used_heap_size, arginfo_v8_heap_statistics__used_heap_size, ZEND_ACC_PUBLIC)
        PHP_ME(V8HeapStatistics, heap_size_limit, arginfo_v8_heap_statistics__heap_size_limit, ZEND_ACC_PUBLIC)
        PHP_ME(V8HeapStatistics, does_zap_garbage, arginfo_v8_heap_statistics__does_zap_garbage, ZEND_ACC_PUBLIC)

        PHP_FE_END
};


PHP_MINIT_FUNCTION (php_v8_heap_statistics) {
    zend_class_entry ce;
    INIT_NS_CLASS_ENTRY(ce, PHP_V8_NS, "HeapStatistics", php_v8_heap_statistics_methods);
    this_ce = zend_register_internal_class(&ce);

    zend_declare_property_double(this_ce, ZEND_STRL("total_heap_size"), 0, ZEND_ACC_PRIVATE);
    zend_declare_property_double(this_ce, ZEND_STRL("total_heap_size_executable"), 0, ZEND_ACC_PRIVATE);
    zend_declare_property_double(this_ce, ZEND_STRL("total_physical_size"), 0, ZEND_ACC_PRIVATE);
    zend_declare_property_double(this_ce, ZEND_STRL("total_available_size"), 0, ZEND_ACC_PRIVATE);
    zend_declare_property_double(this_ce, ZEND_STRL("used_heap_size"), 0, ZEND_ACC_PRIVATE);
    zend_declare_property_double(this_ce, ZEND_STRL("heap_size_limit"), 0, ZEND_ACC_PRIVATE);

    zend_declare_property_bool(this_ce, ZEND_STRL("does_zap_garbage"), false, ZEND_ACC_PRIVATE);

    return SUCCESS;
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
