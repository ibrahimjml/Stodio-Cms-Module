<?php

namespace Modules\Auditlog\Enums;

enum AuditPeriod: int
{
     const NEVER = 0;

     const ONE_DAY = 1;

     const ONE_WEEK = 7;

     const ONE_MONTH = 30;

     const THREE_MONTHS = 90;

     const SIX_MONTHS = 180;
}
