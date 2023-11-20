<?php
declare(strict_types=1);

namespace Histel\LumenSail;

abstract class DockerServicesEnum
{
    const MYSQL = 'mysql';
    const PGSQL = 'pgsql';
    const MARIADB = 'mariadb';
    const REDIS = 'redis';
    const MEILI_SEARCH = 'meilisearch';
    const MINIO = 'minio';
    const SELENIUM = 'selenium';
    const MEMCACHED = 'memcached';
    const MAIL_HOG = 'mailhog';
}