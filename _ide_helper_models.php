<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $organization_id
 * @property int $location_id
 * @property string $name
 * @property string $asset_code
 * @property string|null $manufacturer
 * @property string|null $model
 * @property string|null $serial_number
 * @property string|null $notes
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\Organization $organization
 * @property-read \App\Models\WorkOrderAsset|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrder> $workOrders
 * @property-read int|null $work_orders_count
 * @method static \Database\Factories\AssetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereAssetCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereUpdatedAt($value)
 */
	class Asset extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $organization_id
 * @property string $company_name
 * @property string|null $contact_person
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $notes
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locations
 * @property-read int|null $locations_count
 * @property-read \App\Models\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrder> $workOrders
 * @property-read int|null $work_orders_count
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $organization_id
 * @property int $customer_id
 * @property string $name
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property string|null $notes
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asset> $assets
 * @property-read int|null $assets_count
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrder> $workOrders
 * @property-read int|null $work_orders_count
 * @method static \Database\Factories\LocationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereUpdatedAt($value)
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string|null $phone_number
 * @property string|null $description
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asset> $assets
 * @property-read int|null $assets_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderComment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Customer> $customers
 * @property-read int|null $customers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Location> $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderAttachment> $workOrderAttachments
 * @property-read int|null $work_order_attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrder> $workOrders
 * @property-read int|null $work_orders_count
 * @method static \Database\Factories\OrganizationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereUpdatedAt($value)
 */
	class Organization extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $organization_id
 * @property \App\Enums\UserRole $role
 * @property string $name
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property \Carbon\CarbonImmutable|null $two_factor_confirmed_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderAssignment> $assignedByRecords
 * @property-read int|null $assigned_by_records_count
 * @property-read \App\Models\WorkOrderAssignment|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrder> $assignedWorkOrders
 * @property-read int|null $assigned_work_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderAssignment> $assignments
 * @property-read int|null $assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderComment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrder> $createdWorkOrders
 * @property-read int|null $created_work_orders_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Organization|null $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passkeys\Passkey> $passkeys
 * @property-read int|null $passkeys_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderAttachment> $workOrderAttachments
 * @property-read int|null $work_order_attachments_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Laravel\Fortify\Contracts\PasskeyUser, \Laravel\Passkeys\Contracts\PasskeyUser {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $organization_id
 * @property int $customer_id
 * @property int $location_id
 * @property int $created_by
 * @property string $title
 * @property string|null $description
 * @property \App\Enums\WorkOrderStatus $status
 * @property \App\Enums\WorkOrderPriority $priority
 * @property \Carbon\CarbonImmutable|null $scheduled_at
 * @property \Carbon\CarbonImmutable|null $due_at
 * @property \Carbon\CarbonImmutable|null $started_at
 * @property \Carbon\CarbonImmutable|null $completed_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\WorkOrderAssignment|\App\Models\WorkOrderAsset|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asset> $assets
 * @property-read int|null $assets_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderAssignment> $assignments
 * @property-read int|null $assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderAttachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkOrderComment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\Organization $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $technicians
 * @property-read int|null $technicians_count
 * @method static \Database\Factories\WorkOrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereDueAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrder whereUpdatedAt($value)
 */
	class WorkOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $work_order_id
 * @property int $asset_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Asset $asset
 * @property-read \App\Models\WorkOrder $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAsset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAsset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAsset query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAsset whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAsset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAsset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAsset whereWorkOrderId($value)
 */
	class WorkOrderAsset extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $work_order_id
 * @property int $user_id
 * @property int $assigned_by
 * @property \Carbon\CarbonImmutable $assigned_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User $assignedBy
 * @property-read \App\Models\User $technician
 * @property-read \App\Models\WorkOrder $workOrder
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAssignment whereAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAssignment whereAssignedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAssignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAssignment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAssignment whereWorkOrderId($value)
 */
	class WorkOrderAssignment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $organization_id
 * @property int $work_order_id
 * @property int $uploaded_by
 * @property string $path
 * @property string $file_name
 * @property string $mime_type
 * @property int $file_size
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Organization $organization
 * @property-read \App\Models\User $uploader
 * @property-read \App\Models\WorkOrder $workOrder
 * @method static \Database\Factories\WorkOrderAttachmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment whereUploadedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderAttachment whereWorkOrderId($value)
 */
	class WorkOrderAttachment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $organization_id
 * @property int $work_order_id
 * @property int $user_id
 * @property string $comment
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Organization $organization
 * @property-read \App\Models\User $user
 * @property-read \App\Models\WorkOrder $workOrder
 * @method static \Database\Factories\WorkOrderCommentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderComment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderComment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderComment whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderComment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkOrderComment whereWorkOrderId($value)
 */
	class WorkOrderComment extends \Eloquent {}
}

