<?php
/*
Plugin Name: Reservations
*/

function create_table_reservations() {
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $sql = "CREATE TABLE IF NOT EXISTS reservations (
        `id` int(11) not null AUTO_INCREMENT, 
        `name` varchar(128) null,
        `email` varchar(128) null,
        `datetime` datetime null,
        `visitors_count` int null,
        `ip` varchar(128) null,
        `status` int(11) null,
        PRIMARY KEY id (id)
    );";

    dbDelta( $sql );
}

function delete_reservations_table() {
    global $wpdb;
    $wpdb->query('DROP TABLE reservations');
}

function reservations_page_list() {
    global $wpdb;
    $listTable = new ReservationListTable();
    $listTable->prepare_items();
    ?>
    <div class="reservations">
        <h1 class="wp-heading">Book list</h1>

        <?php $listTable->display(); ?>
    </div>
    <?php
}

function add_reservations_page_list() {
    add_menu_page('Book List', 'Book List', 'manage_options', 'reservations_list', 'reservations_page_list', 'page');
    add_submenu_page(null, 'Reservation', 'Reservation', 'manage_options', 'reservation_item', 'reservation_item_page');
}

function reservation_confirm() {
    $id = $_GET['id'];
    global $wpdb;

    $wpdb->update('reservations', [
        'status' => 1,
    ], ['id' => $id]);

    wp_redirect(wp_get_referer());
}

function reservation_item_page()
{
    global $wpdb;

    $id = $_GET['id'];
    $item = $wpdb->get_row($wpdb->prepare('SELECT * FROM reservations WHERE id = %d', $id), ARRAY_A);

    ?>

    <div class="reservation">
        <h1 class="wp-heading">Reservation</h1>

        <ul>
            <li>
                <b>Name: </b>
                <?php echo $item['name']; ?>
            </li>
            <li>
                <b>E-mail: </b>
                <?php echo $item['name']; ?>
            </li>
            <li>
                <b>Datetime: </b>
                <?php echo date('d.m.Y H:i:s', $item['datetime']); ?>
            </li>
            <li>
                <b>Visitors Count: </b>
                <?php echo $item['visitors_count']; ?>
            </li>
            <li>
                <b>Status: </b>
                <?php echo $item['status']; ?>
            </li>
            <li>
                <b>IP: </b>
                <?php echo $item['ip']; ?>
            </li>
        </ul>

        <br>

        <?php if($item['status'] == 0): ?>
            <a href="<?php echo admin_url('admin-post.php?action=reservation_confirm&id='.$item['id']); ?>">Confirm</a>
        <?php endif; ?>
    </div>
    <?php
}

function create_reservation()
{
    global $wpdb;

    $wpdb->insert('reservations', [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'datetime' => $_POST['date'] . ' ' . $_POST['time'],
        'visitors_count' => $_POST['visitors_count'] ?? 0,
        'ip' => $_SERVER['REMOTE_ADDR'],
        'status' => 0,
    ]);

    wp_redirect(home_url());
}

add_action('admin_post_reservation_confirm', 'reservation_confirm');
add_action('admin_post_create_reservation', 'create_reservation');
add_action('admin_menu', 'add_reservations_page_list');

register_activation_hook( __FILE__, 'create_table_reservations' );
register_deactivation_hook(__FILE__, 'delete_reservations_table');

// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class ReservationListTable extends WP_List_Table
{
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );

        $perPage = 20;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'id'          => 'ID',
            'name'       => 'Name',
            'email' => 'Email',
            'datetime'        => 'Reservation datetime',
            'visitors_count'      => 'Visitors Count',
            'ip' => 'IP',
            'status' => 'Status',
            'actions' => 'Actions'
        );

        return $columns;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array(
            'id' => array('id', true),
            'name' => array('name', true),
            'email' => array('email', true),
            'visitors_count' => array('visitors_count', true),
            'ip' => array('ip', true),
            'status' => array('status', true),
            'datetime' => array('datetime', true)
        );
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM reservations", ARRAY_A);
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'id':
            case 'name':
            case 'email':
            case 'visitors_count':
            case 'ip':
            case 'datetime':
                return '<a href="'.admin_url('/reservation/' . $item['id']) . '">' . $item[ $column_name ] . '</a>';
            case 'status':
                return $item['status'] == 0 ? 'Not confirmed' : 'Confirmed';
            case 'actions':
                if($item['status'] == 0) {
                    return '<a href="'.admin_url('admin-post.php?action=reservation_confirm&id='.$item['id']).'">Confirm</a>';
                }

                return '-';
            default:
                return print_r( $item, true ) ;
        }
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        $orderby = 'status';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }


        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc')
        {
            return $result;
        }

        return -$result;
    }
}
