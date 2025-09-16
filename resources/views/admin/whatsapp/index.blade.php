@extends('adminlte::page')

@section('title', 'WhatsApp Management')

@section('content_header')
    <h1><i class="fab fa-whatsapp text-success"></i> WhatsApp Management</h1>
@stop

@section('content')
<div class="row">
    <!-- Service Status Card -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-server"></i> Service Status</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-sm btn-primary" onclick="refreshStatus()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="service-status">
                    @if($serviceStatus['status'] === 'connected')
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> <strong>Service Online</strong><br>
                            <small>{{ $serviceStatus['message'] }}</small>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-times-circle"></i> <strong>Service Offline</strong><br>
                            <small>{{ $serviceStatus['message'] }}</small>
                        </div>
                    @endif
                </div>

                <table class="table table-sm">
                    <tr>
                        <td><strong>Service URL</strong></td>
                        <td>{{ $config['service_url'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Admin Phone</strong></td>
                        <td>{{ $config['admin_phone'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>
                            @if($config['enabled'])
                                <span class="badge badge-success">Enabled</span>
                            @else
                                <span class="badge badge-danger">Disabled</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Device Status Card -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-mobile-alt"></i> Device Status</h3>
                <div class="card-tools">
                    <a href="{{ $config['service_url'] }}" target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-external-link-alt"></i> Open Dashboard
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="device-status">
                    @if($deviceStatus['status'] === 'connected')
                        <div class="alert alert-success">
                            <i class="fas fa-mobile-alt"></i> <strong>Device Connected</strong><br>
                            <small>{{ $deviceStatus['message'] }}</small>
                            @if(isset($deviceStatus['device_count']))
                                <br><small>Active devices: {{ $deviceStatus['device_count'] }}</small>
                            @endif
                        </div>
                    @elseif($deviceStatus['status'] === 'not_connected')
                        <div class="alert alert-warning">
                            <i class="fas fa-qrcode"></i> <strong>Device Not Connected</strong><br>
                            <small>{{ $deviceStatus['message'] }}</small>
                        </div>

                        @if(isset($loginStatus['data']['results']['qr_link']))
                            <div class="mt-3">
                                <h6>Scan QR Code:</h6>
                                <img src="{{ $loginStatus['data']['results']['qr_link'] }}"
                                     alt="QR Code" class="img-fluid" style="max-width: 200px;">
                                <p class="text-muted mt-2">
                                    <small>QR Code expires in {{ $loginStatus['data']['results']['qr_duration'] ?? 30 }} seconds</small>
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Device Error</strong><br>
                            <small>{{ $deviceStatus['message'] }}</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Messages Section -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-paper-plane"></i> Test Messages</h3>
            </div>
            <div class="card-body">
                <form id="test-message-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="test-phone">Phone Number</label>
                                <input type="text" class="form-control" id="test-phone" name="phone"
                                       value="{{ $config['admin_phone'] }}" placeholder="628123456789">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="test-type">Message Type</label>
                                <select class="form-control" id="test-type" name="type">
                                    <option value="admin">Admin Notification</option>
                                    <option value="guest">Guest Confirmation</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane"></i> Send Test Message
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="test-message">Custom Message (optional)</label>
                        <textarea class="form-control" id="test-message" name="message" rows="3"
                                  placeholder="Leave empty to use default template message">Test message dari PTSP Kemenag Nganjuk</textarea>
                    </div>
                </form>

                <div id="test-result" class="mt-3" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Usage Instructions -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Usage Instructions</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-1"></i> Setup Device</h6>
                        <ol>
                            <li>Open <a href="{{ $config['service_url'] }}" target="_blank">WhatsApp Dashboard</a></li>
                            <li>Login with: <code>admin</code> / <code>admin</code></li>
                            <li>Scan QR Code with WhatsApp</li>
                            <li>Wait for "Device Connected" status</li>
                        </ol>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-2"></i> How It Works</h6>
                        <ul>
                            <li>Admin gets notification when guest checks in</li>
                            <li>Guest gets confirmation if phone number provided</li>
                            <li>Messages sent automatically via WhatsApp API</li>
                            <li>All activities logged for monitoring</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
function refreshStatus() {
    $('#service-status, #device-status').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');

    // Ensure HTTPS URL for AJAX request
    let url = '{{ route("admin.whatsapp.test-connection") }}';
    if (window.location.protocol === 'https:' && url.startsWith('http:')) {
        url = url.replace('http:', 'https:');
    }

    $.get(url)
        .done(function(data) {
            if (data.success) {
                updateServiceStatus(data.service);
                updateDeviceStatus(data.device);
            } else {
                showError('Failed to refresh status: ' + data.message);
            }
        })
        .fail(function() {
            showError('Failed to connect to server');
        });
}

function updateServiceStatus(status) {
    let html = '';
    if (status.status === 'connected') {
        html = `<div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <strong>Service Online</strong><br>
            <small>${status.message}</small>
        </div>`;
    } else {
        html = `<div class="alert alert-danger">
            <i class="fas fa-times-circle"></i> <strong>Service Offline</strong><br>
            <small>${status.message}</small>
        </div>`;
    }
    $('#service-status').html(html);
}

function updateDeviceStatus(status) {
    let html = '';
    if (status.status === 'connected') {
        html = `<div class="alert alert-success">
            <i class="fas fa-mobile-alt"></i> <strong>Device Connected</strong><br>
            <small>${status.message}</small>
        </div>`;
    } else if (status.status === 'not_connected') {
        html = `<div class="alert alert-warning">
            <i class="fas fa-qrcode"></i> <strong>Device Not Connected</strong><br>
            <small>${status.message}</small>
        </div>`;
    } else {
        html = `<div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i> <strong>Device Error</strong><br>
            <small>${status.message}</small>
        </div>`;
    }
    $('#device-status').html(html);
}

$('#test-message-form').on('submit', function(e) {
    e.preventDefault();

    const submitBtn = $(this).find('button[type="submit"]');
    const originalText = submitBtn.html();

    submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);

    // Ensure HTTPS URL for AJAX request
    let url = '{{ route("admin.whatsapp.test-message") }}';
    if (window.location.protocol === 'https:' && url.startsWith('http:')) {
        url = url.replace('http:', 'https:');
    }

    $.post(url, $(this).serialize())
        .done(function(data) {
            if (data.success) {
                $('#test-result').html(`
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> ${data.message}
                    </div>
                `).show();
            } else {
                $('#test-result').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> ${data.message}
                    </div>
                `).show();
            }
        })
        .fail(function(xhr) {
            const message = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to send message';
            $('#test-result').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle"></i> Error: ${message}
                </div>
            `).show();
        })
        .always(function() {
            submitBtn.html(originalText).prop('disabled', false);
        });
});

function showError(message) {
    $('#service-status, #device-status').html(`
        <div class="alert alert-danger">
            <i class="fas fa-times-circle"></i> <strong>Error</strong><br>
            <small>${message}</small>
        </div>
    `);
}

// Auto refresh every 30 seconds
setInterval(refreshStatus, 30000);
</script>
@stop
