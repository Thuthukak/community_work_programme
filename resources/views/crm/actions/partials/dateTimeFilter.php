
        <form id="dateRangeForm" class="filter-form">
            <div class="date-form d-flex">
                <input autocomplete="off" class="form-control input-sm" name="st_date" id="filter_started_at" placeholder="Start date">
                <input autocomplete="off" class="form-control input-sm ml-md-2" name="fin_date" id="filter_finished_at" placeholder="Settlement date">
                <select name="order" Id="sort_by" class="form-control input-sm ml-md-2">
                    <option value="">Sort by</option>
                    <option value="started_at_asc">Start date, earliest to latest</option>
                    <option value="started_at_desc">Start date, latest to earliest</option>
                    <option value="finished_at_asc">Finish date, earliest to latest</option>
                    <option value="finished_at_desc">Finish date, latest to earliest</option>
                    <option value="updated_at_asc">Recently updated, earliest to latest</option>
                    <option value="updated_at_desc">Recently updated, latest to earliest</option>
                </select>
                <button class="btn btn-info ml-md-2" id="applyDates">Filter</button>
            </div>
        </form>

 