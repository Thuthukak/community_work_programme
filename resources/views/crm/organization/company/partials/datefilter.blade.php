<div class="row m-3 pt-4 justify-content-center">
            <div class="col-auto mb-2">
            <form action="{{ $company->getOKrRoute() }}" class="form-inline search-form">
                <input autocomplete="off" class="form-control input-sm" name="st_date" id="filter_started_at" value=""
                    placeholder="Start date">
                <input autocomplete="off" class="form-control input-sm ml-md-2" name="fin_date" id="filter_finished_at"
                    value="" placeholder="Settlement date">
                <select name="order" class="form-control input-sm mr-md-2 ml-md-2">
                    <option value="">Sort by</option>
                    <option value="started_at_asc">Start date, earliest to latest</option>
                    <option value="started_at_desc">Start date, latest to earliest</option>
                    <option value="finished_at_asc">Finish date, earliest to latest</option>
                    <option value="finished_at_desc">Finish date, latest to earliest</option>
                    <option value="updated_at_asc">Recently updated, earliest to latest</option>
                    <option value="updated_at_desc">Recently updated, latest to earliest</option>
                </select>
                <button class="btn btn-info">Filter</button>
            </form>
        </div>
</div>