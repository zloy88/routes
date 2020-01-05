<?php
declare(strict_types = 1);

namespace LMS\Routes\Middleware\Api;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use LMS\Facade\Extbase\{User, ExtensionHelper};

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class VerifyUser extends AbstractRouteMiddleware
{
    use ExtensionHelper;

    /**
     * {@inheritDoc}
     */
    public function process(): void
    {
        if ($this->getUser() === $this->getRequestUserID()) {
            return;
        }

        if (in_array(User::currentUid(), $this->getAdminUsers(), true)) {
            return;
        }

        $this->deny('User is not a resource owner.', 403);
    }

    /**
     * Retrieves the value of the action parameter that contains <user identifier>
     *
     * @return int
     */
    private function getRequestUserID(): int
    {
        return (int)$this->getQuery()[$this->getUserPropertyName()];
    }

    /**
     * Retrieve the name of the parameter that related to user field
     *
     * @return string
     */
    private function getUserPropertyName(): string
    {
        return (string)$this->getProperties()[0];
    }

    /**
     * Retrieve the name of the extension that is related to the endpoint
     *
     * @return string
     */
    private function getAdminExtensionName(): string
    {
        return (string)$this->getProperties()[1] ?: self::extensionTypoScriptKey();
    }

    /**
     * Find all admin users related to current request
     *
     * @return array
     */
    private function getAdminUsers(): array
    {
        $ext = $this->getAdminExtensionName();

        $admins = $this->getSettings($ext)['middleware.']['admin.']['users'];

        return GeneralUtility::intExplode(',', $admins, true);
    }
}
