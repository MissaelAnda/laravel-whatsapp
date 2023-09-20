<?php

namespace MissaelAnda\Whatsapp\Template;

enum TemplateStatus: string
{
    case Approved = 'APPROVED';
    case Rejected = 'REJECTED';
    case Paused = 'PAUSED';
    case Pending = 'PENDING';
    case PendingDeletion = 'PENDING_DELETION';
}
