<?php
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\AppSettings;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Models\EmailPageDesign;
use App\Models\LogActivity as ModelsLogActivity;
use App\Models\LoginHistories;
use App\Models\SupportTicketPriority;
use App\Models\SupportTicket;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

/**
 * Get PHP Time Zone
 */
function getAllTimeZonesSelectBox($selectedValue)
{
	echo '<select name="site_timezone" class="form-control select2bs4" id="site_timezone" required="required">';
	echo '<option value="">-- Select Time Zone --</option>';
	$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
	foreach ($tzlist as $value) {
		$selected = ($value === $selectedValue) ? 'selected="selected"' : '';
		echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
	}
	echo '</select>';
}


/**
 * Get Settings
 */
function DiligentCreators($value)
{
	return AppSettings::where('setting_name', $value)->value('setting_value');
}

/**
 * Generate Support Ticket Number
 */
function generateSupportTicketNumber()
{
	// $id = uniqid() . '-' . date('zdmY') . '-' . time() . '-' . uniqid();
	// $id = date('z') . '-' . date('d') . '-' . date('m') . '-' . date('Y') . '-' . time();
	$id = time();
	// return strtoupper($id);
	return $id;
}

/**
 * Get Support Ticket by Status Id
 */
function getSupportTicketStatus($id)
{
	$name = TicketStatus::where('id', $id)->value('name');
	return $name;
}
/**
 * Count Support Ticket by Status Id
 */
function getTotalSupportTicketByStatus($status)
{
	return SupportTicket::where('ticket_status_id', $status)->count();
}

/**
 * Get Support Ticket Priority Id
 */
function getSupportTicketByPriority($id)
{
	$name = SupportTicketPriority::where('id', $id)->value('name');
	return $name;
}

/**
 * Count Support Ticket Priority by Priority Id
 */
function getTotalSupportTicketByPriority($priority)
{
	return SupportTicket::where('support_ticket_priority_id', $priority)->count();
}

/**
 * Get all pending support tickets
 */
function pendingSupportTickets()
{
	$pendingSupportTickets = SupportTicket::where('support_tickets.ticket_status_id', 1)
		->select(
			'support_tickets.*',
			'users.first_name as firstName',
			'users.last_name as lastName',
		)
		->leftJoin('users', 'users.id', 'support_tickets.user_id')
		->orderBy('support_tickets.id', 'desc')
		->limit(10)
		->get();
	foreach ($pendingSupportTickets as $pending) {
?>
		<a href="/admin/support-tickets/<?php echo $pending->id; ?>" class="dropdown-item">
			<!-- Message Start -->
			<div class="media">
				<div class="media-body">
					<h3 class="dropdown-item-title">
						<?php echo $pending->firstName . ' ' . $pending->lastName; ?>
						<span class="float-right text-sm text-theme"><i class="fa-regular fa-life-ring"></i></span>
					</h3>
					<p class="text-sm">Requested for Support</p>
					<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?php echo TimeAgo($pending->created_at); ?></p>
				</div>
			</div>
		</a>
		<div class="dropdown-divider"></div>
	<?php
	}
}

/**
 * Get the human-readable file size for a given file path.
 *
 * @param string $filePath The file path to the attachment.
 * @return string The human-readable file size (e.g., "1.23 MB").
 */
function getFileSize($filePath)
{
	if (file_exists($filePath)) {
		$bytes = filesize($filePath);

		$units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
		$index = 0;

		while ($bytes >= 1024 && $index < count($units) - 1) {
			$bytes /= 1024;
			$index++;
		}

		return sprintf('%.2f %s', $bytes, $units[$index]);
	} else {
		return 'File not found';
	}
}

/**
 * Get Email Settings
 */
function EmailPageDesign($value)
{
	return EmailPageDesign::where('setting_name', $value)->value('setting_value');
}


/**
 * Update Status
 */
function UpdateStatus($table_name, $id, $status)
{
	if ($status != null) {
		DB::table($table_name)->where('id', $id)->update([
			'is_active' => $status,
		]);
		return Session::flash('message', [
			'text' => "Status has been changed successfully",
		]);
	}
}


/**
 * Get User Full Name By Id
 */
function GetUserName($userid)
{
	$firstName = User::where('id', $userid)->value('first_name');
	$lastName = User::where('id', $userid)->value('last_name');
	return $firstName . ' ' . $lastName;
}

/**
 * Get Admin Full Name by Id
 */
function GetAdminName($id)
{
	return Admin::where('id', $id)->value('name');
}

/**
 * Get Locations
 * Get Country Name
 * Get State Name
 * Get City Name
 */
function GetCountry($id)
{
	return Country::where('id', $id)->value('name');
}
function GetState($id)
{
	return State::where('id', $id)->value('state_name');
}
function GetCity($id)
{
	return City::where('id', $id)->value('city_name');
}

/**
 * Generate Random Password
 */
function GeneratePassword($length = 8)
{
	// Define character pools for each type of character
	$lowercase = "abcdefghijklmnopqrstuvwxyz";
	$uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$numbers = "0123456789";
	$special = "#@!+";

	// Initialize the password as an empty string
	$password = '';

	// Generate 3 random lowercase characters
	for ($i = 0; $i < 3; $i++) {
		$password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
	}

	// Generate 3 random uppercase characters
	for ($i = 0; $i < 3; $i++) {
		$password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
	}

	// Generate 1 random number
	$password .= $numbers[random_int(0, strlen($numbers) - 1)];

	// Generate 1 random special character
	$password .= $special[random_int(0, strlen($special) - 1)];

	// Fill the rest of the password with random characters from all pools
	for ($i = strlen($password); $i < $length; $i++) {
		$pool = $lowercase . $uppercase . $numbers . $special;
		$password .= $pool[random_int(0, strlen($pool) - 1)];
	}

	// Shuffle the characters in the password
	$password = str_shuffle($password);

	return $password;
}

/**
 * Generate Random Password JS
 */
function GeneratePasswordJS($generatePasswordBtn, $password, $length = 12)
{
    ?>
    <script>
        $('#<?php echo $generatePasswordBtn; ?>').click(function(e) {
            let characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            let result = '';
            for (let i = 0; i < <?php echo $length; ?>; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            $("#<?php echo $password; ?>").val(result);
        });
    </script>
    <?php
}

/**
 * Time ago with carbon date and time
 */
function TimeAgo($time)
{
	return Carbon::parse($time)->diffForHumans();
}

/**
 * Date Format
 */
function DateFormat($date)
{
	return date("l, F d, Y", strtotime($date));
}
function TimeFormat($date)
{
	return date("h:i:s A", strtotime($date));
}

/**
 * Number format 
 * "K", "M", "B", "T"
 */
function simplifyNumber($number)
{
	if ($number < 1000) {
		return number_format($number, 2);
	} elseif ($number < 1000000) {
		// return round($number / 1000, 1) . 'K';
		return number_format($number);
	} elseif ($number < 1000000000) {
		return round($number / 1000000, 1) . 'M';
	} elseif ($number < 1000000000000) {
		return round($number / 1000000000, 1) . 'B';
	} else {
		return round($number / 1000000000000, 1) . 'T';
	}
}

/**
 * User Activity Log
 */
function userLogActivity()
{
	$logActivity = ModelsLogActivity::select(
		'log_activities.*',
		'users.first_name as firstName',
		'users.last_name as lastName',
	)
		->join('users', 'users.id', 'log_activities.user_id')
		->orderBy('log_activities.id', 'desc')
		->limit(5)
		->get();

	foreach ($logActivity as $log) {
	?>
		<div class="dropdown-item">
			<div class="media">
				<!-- <img src="/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle"> -->
				<div class="media-body">
					<h3 class="dropdown-item-title">
						<?php echo $log->firstName . ' ' . $log->lastName; ?>
					</h3>
					<p class="text-sm"><?php echo $log->subject; ?></p>
					<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?php echo TimeAgo($log->created_at); ?></p>
				</div>
			</div>
		</div>
	<?php
	}
}

/**
 * User Login History
 */
function userLoginHistory()
{
	$users = LoginHistories::select(
		'login_histories.*',
		'users.first_name as firstName',
		'users.last_name as lastName',
	)
		->join('users', 'users.id', 'login_histories.user_id')
		->orderBy('login_histories.id', 'desc')
		->limit(5)
		->get();

	foreach ($users as $user) {
	?>
		<a href="/admin/clients/<?php echo $user->user_id; ?>/edit" class="dropdown-item">
			<div class="media">
				<div class="media-body">
					<h3 class="dropdown-item-title">
						<?php echo $user->firstName . ' ' . $user->lastName; ?>
						<span class="float-right text-sm text-green"><i class="fas fa-star"></i></span>
					</h3>
					<p class="text-sm">Logged In</p>
					<p class="text-sm text-muted">
						<i class="far fa-clock mr-1"></i>
						<?php echo TimeAgo($user->date_time); ?>
					</p>
				</div>
			</div>
		</a>
		<div class="dropdown-divider"></div>
<?php
	}
}

/**
 * Convert HTML to Text
 */
function shortTextWithOutHtml($text, $limit = 25)
{
	$plainText = strip_tags($text);
	$limitedText = (strlen($plainText) > $limit) ? substr($plainText, 0, $limit) . "..." : $plainText;
	return $limitedText;
}

/**
 * Check Permissions for Blade
 */
function canAccess($permissionName)
{
	$user = Auth::guard('admin')->user();

	// Skip permission checks for user with ID 1 (super admin)
	if ($user->id === 1) {
		return true;
	}

	$roleNames = $user->getRoleNames(); // Get role names associated with the user

	$hasPermission = false;

	foreach ($roleNames as $roleName) {
		$role = Role::where('name', $roleName)->first();

		if ($role && $role->hasPermissionTo($permissionName)) {
			$hasPermission = true;
			break;
		}
	}
	return $hasPermission;
}

/**
 * Check permission in controller
 */
function hasAccess($access)
{
	if (!canAccess($access)) {
        Session::flash('error', [
            'text' => 'You are not authorized to access the page.',
        ]);
        // return redirect()->route('admin.dashboard');
		abort(403);
    }
}