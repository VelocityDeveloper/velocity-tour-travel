<?php
$current_url = esc_url($_SERVER['REQUEST_URI']);
$no_pemesanan = get_option('no_pemesanan');
if (isset($_POST['no_pemesanan'])) {
    $no_pemesanan = sanitize_text_field($_POST['no_pemesanan']);
    $no_pemesanan = preg_replace('/\D/', '', $no_pemesanan);
    update_option('no_pemesanan', $no_pemesanan);
}
?>
<form method="post" class="form-wrap" action="<?php echo $current_url; ?>">
    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th scope="row">No. Whatsapp Pemesanan</th>
                <td><input class="regular-text" type="text" name="no_pemesanan" value="<?php echo $no_pemesanan;?>" required></td>
            </tr>
        </tbody>
    </table>

    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button button-primary" value="Simpan">
    </p>
</div>