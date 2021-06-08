<?php $this->start('head'); ?>
<!-------Costum-------->
<link
    href="<?= $this->asset('css/custom/admin/calendar', 'css') ?? ''?>"
    rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="page-content">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ps-0 fs-base">
            <li class="breadcrumb-item"><a href="#">FlexAdmin</a></li>
            <li class="breadcrumb-item"><span>Calendar</span></li>
        </ol>
    </nav>
    <div class="header mb-2">
        <h1 class="header-title h3">
            <i class="fal fa-calendar text-highlight"></i>
            Calendar
        </h1>
        <p class="mt-2">
            Full-sized drag & drop event calendar
        </p>
    </div>
    <div class="bd-callout bd-callout-highlight bg-highlight-100 d-flex align-items-center mb-5" role="alert">
        <div class="alert-icon"><i class="fal fa-info-circle text-highlight fs-xxl me-3"></i></div>
        <div class="alert-text">
            <h4>The FullCalendar Approach</h4>
            <p><a href="https://fullcalendar.io/" target="_blank" class="text-highlight fw-700">FullCalendar</a> is
                great
                for displaying events, but it isn't a complete solution for event content-management. Beyond dragging an
                event to a different time/day, you cannot change an event's name or other associated data. It is up to
                you
                to add this functionality through <a href="https://fullcalendar.io/docs#toc" target="_blank"
                    class="text-highlight fw-700">FullCalendar's API.</a></p>
        </div>
    </div>
    <!-- Add New External Event MODAL -->
    <div class="modal fade" id="external-event-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-700">Create New External Event</h4>
                    <a href="#" class="pos-top-right p-2 m-1 me-2 fs-md" data-dismiss="modal" aria-label="Close"><i
                            class="fal fa-times"></i></a>
                </div>
                <form>
                    <div class="modal-body pt-3 pe-4 ps-4">
                        <div class='mb-3'>
                            <label for="external-event-title">Title</label>
                            <input class='form-control' id='external-event-title' type="text" required />
                        </div>
                        <div class='mb-3'>
                            <label for="external-event-color">Color</label>
                            <select id="external-event-color" class="form-select">
                                <option value="primary">Primary</option>
                                <option value="info">Info</option>
                                <option value="success">Success</option>
                                <option value="warning">Warning</option>
                                <option value="danger">Danger</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-end pb-4 pe-4">
                        <button type="submit" class="btn btn-primary save-event">Save</button>
                    </div>
                </form>
            </div>
            <!-- end modal-content-->
        </div>
        <!-- end modal dialog-->
    </div>
    <!-- end modal-->
    <div class="card">
        <div class="card-body">
            <div class="row full-calendar">
                <div class="col-lg-3">
                    <a href="#" class="btn btn-highlight mb-4" data-bs-toggle="modal"
                        data-target="#external-event-modal"><i class="fal fa-calendar-plus"></i> New External Event</a>
                    <div id="calendar-external-events">
                        <p class="text-muted">Drag these onto the calendar:</p>
                        <div class="external-event btn btn-success d-block mb-3 text-white text-start cursor-move"
                            data-color-class="bg-success" data-description="Lorem ipsum dolor amet">
                            <i class="fas fa-circle me-2"></i>
                            Stand up
                        </div>
                        <div class="external-event btn btn-info d-block mb-3 text-white text-start"
                            data-color-class="bg-info" data-description="Lorem ipsum dolor amet info">
                            <i class="fas fa-circle me-2"></i>
                            Grooming
                        </div>
                        <div class="external-event btn btn-warning d-block mb-3 text-white text-start"
                            data-color-class="bg-warning" data-description="Lorem ipsum dolor amet warning">
                            <i class="fas fa-circle me-2"></i>
                            Release Project
                        </div>
                        <div class="external-event btn btn-danger d-block mb-3 text-white text-start"
                            data-color-class="bg-danger" data-description="Lorem ipsum dolor amet danger">
                            <i class="fas fa-circle me-2"></i>
                            Kick Start Project
                        </div>
                    </div>
                    <div class="custom-control mt-3">
                        <label class="custom-checkbox">
                            <input type="checkbox" id="drop-remove"> Remove after drop
                            <span></span>
                        </label>
                    </div>
                </div>
                <!-- end col-->
                <div class="col-lg-9">
                    <div id="demo-calendar">
                    </div>
                    <!-- end col-->
                </div>
                <!-- end row-->
            </div>
            <!-- end full-calendar -->
        </div>
        <!-- end card-body -->
    </div>
    <!-- end card -->
</div>

<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript"
    src="<?= $this->asset('js/custom/admin/calendar', 'js') ?? ''?>">
</script>
<?php $this->end();
