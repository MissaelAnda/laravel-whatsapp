<?php

namespace MissaelAnda\Whatsapp;

enum BusinessVertical: string
{
    case Undefined = 'UNDEFINED';
    case Other = 'OTHER';
    case Auto = 'AUTO';
    case Beauty = 'BEAUTY';
    case Apparel = 'APPAREL';
    case Edu = 'EDU';
    case Entertain = 'ENTERTAIN';
    case EventPlan = 'EVENT_PLAN';
    case Finance = 'FINANCE';
    case Grocery = 'GROCERY';
    case Govt = 'GOVT';
    case Hotel = 'HOTEL';
    case Health = 'HEALTH';
    case NonProfit = 'NONPROFIT';
    case ProfServices = 'PROF_SERVICES';
    case Retail = 'RETAIL';
    case Travel = 'TRAVEL';
    case Restaurant = 'RESTAURANT';
    case NotABiz = 'NOT_A_BIZ';
}
