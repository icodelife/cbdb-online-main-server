@extends('layouts.dashboard')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">地址 Address</div>
        <div class="panel-body">
            <div class="panel-body">
            <form action="{{ route('basicinformation.addresses.update', ['id' => $id, 'addr'=> $id."-".$row->c_addr_id."-".$row->c_addr_type."-".$row->c_sequence]) }}" class="form-horizontal" method="post">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="person_id" class="col-sm-2 control-label">person id</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $id }}" disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_sequence" class="col-sm-2 control-label">遷徙次序</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="c_sequence" value="{{ $row->c_sequence }}" maxlength="4">
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_addr_type" class="col-sm-2 control-label">地址類別(c_addr_type)</label>
                    <div class="col-sm-10">
                        <select-vue name="c_addr_type" model="biogaddr" selected="{{ $row->c_addr_type }}" ></select-vue>
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_addr_id" class="col-sm-2 control-label">地名(c_addr_id)</label>
                    <div class="col-sm-10">
                        <select class="form-control c_addr_id" name="c_addr_id">
                            @if($addr_str)
                            <option value="{{ $row->c_addr_id }}" selected="selected">{{ $addr_str }}</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_firstyear" class="col-sm-2 control-label">始年(c_firstyear)</label>
                    <div class="col-md-1">
                        <input type="number" name="c_firstyear" class="form-control"
                               value="{{ $row->c_firstyear }}">
                    </div>

                    <div class="col-md-2 from-inline">
                        <label for="c_fy_nh_code">年号</label>
                        <select-vue name="c_fy_nh_code" model="nianhao" selected="{{ $row->c_fy_nh_code }}"></select-vue>
                        <input type="number" name="c_fy_nh_year" class="form-control"
                               value="{{ $row->c_fy_nh_year }}">
                        <span for="">年</span>
                    </div>
                    <div class="col-md-3">
                        <label for="">時限</label>
                        <select-vue name="c_fy_range" model="range" selected="{{ $row->c_fy_range }}"></select-vue>
                    </div>
                    <div class="col-md-2">
                        <label for="">閏</label>
                        <select name="c_fy_intercalary" class="form-control select2" name="c_natal">
                            <option disabled value="">请选择</option>
                            <option value="0" {{ ord($row->c_fy_intercalary) == 0? 'selected': '' }}>0-否
                            </option>
                            <option value="1" {{ ord($row->c_fy_intercalary) == 1? 'selected': '' }}>1-是
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" name="c_fy_month" class="form-control"
                               value="{{ $row->c_fy_month }}">
                        <span for="">月</span>
                        <input type="number" name="c_fy_day" class="form-control"
                               value="{{ $row->c_fy_day }}">
                        <span for="">日</span>
                        <label for="">日(干支) </label>
                        <select-vue name="c_fy_day_gz" model="ganzhi" selected="{{ $row->c_fy_day_gz }}"></select-vue>
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_lastyear" class="col-sm-2 control-label">終年(c_lastyear)</label>
                    <div class="col-md-1">
                        <input type="number" name="c_lastyear" class="form-control"
                               value="{{ $row->c_lastyear }}">
                    </div>

                    <div class="col-md-2 from-inline">
                        <label for="c_ly_nh_code">年号</label>
                        <select-vue name="c_ly_nh_code" model="nianhao" selected="{{ $row->c_ly_nh_code }}"></select-vue>
                        <input type="number" name="c_ly_nh_year" class="form-control"
                               value="{{ $row->c_ly_nh_year }}">
                        <span for="">年</span>
                    </div>
                    <div class="col-md-3">
                        <label for="">時限</label>
                        <select-vue name="c_ly_range" model="range" selected="{{ $row->c_ly_range }}"></select-vue>
                    </div>
                    <div class="col-md-2">
                        <label for="">閏</label>
                        <select name="c_ly_intercalary" class="form-control select2" name="c_natal">
                            <option disabled value="">请选择</option>
                            <option value="0" {{ $row->c_ly_intercalary == 0? 'selected': '' }}>0-否
                            </option>
                            <option value="1" {{ $row->c_ly_intercalary == 1? 'selected': '' }}>1-是
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <input type="number" name="c_ly_month" class="form-control"
                               value="{{ $row->c_ly_month }}">
                        <span for="">月</span>
                        <input type="number" name="c_ly_day" class="form-control"
                               value="{{ $row->c_ly_day }}">
                        <span for="">日</span>
                        <label for="">日(干支) </label>
                        <select-vue name="c_ly_day_gz" model="ganzhi" selected="{{ $row->c_ly_day_gz }}"></select-vue>
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_source" class="col-sm-2 control-label">出處(c_source)</label>
                    <div class="col-sm-5">
                        <select class="form-control c_source" name="c_source">
                            @if($text_str)
                            <option value="{{ $row->c_source }}" selected="selected">{{ $text_str }}</option>
                            @endif
                        </select>
                    </div>
                    <label for="c_pages" class="col-sm-2 control-label">頁數/條目</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" name="c_pages" value="{{ $row->c_pages }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="c_notes" class="col-sm-2 control-label">注(c_notes)</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="c_notes" id="" cols="30"
                                  rows="5">{{ $row->c_notes }}</textarea>

                    </div>
                </div>
                <div class="form-group">
                    <label for="c_natal" class="col-sm-2 control-label">娘家地址(c_natal)</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" name="c_natal">
                            <option disabled value="">请选择</option>
                            <option value="0" {{ $row->c_natal == 0? 'selected': '' }}>0-否
                            </option>
                            <option value="1" {{ $row->c_natal == 1? 'selected': '' }}>1-是
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">建檔</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control"
                               value="{{ $row->c_created_by.'/'.$row->c_created_date }}"
                               disabled>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">更新</label>
                    <div class="col-sm-10">
                        <input type="text" name="" class="form-control"
                               value="{{ $row->c_modified_by.'/'.$row->c_modified_date }}"
                               disabled>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(".select2").select2();
        $(".c_addr_id").select2(options('addr'));
        $(".c_source").select2(options('text'));

        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }

            return "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" +
                repo.text +
                "</div></div></div>";
        }

        function formatRepoSelection (repo) {
            return repo.text || repo.text;
        }

        function options(model) {
            return {
                ajax: {
                    url: "/api/select/search/"+model,
                    dataType: 'json',
                    delay: 250,
                    headers: {
                        "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImY3NGZlOTk0ZDkxNWE4ZjdjYjljZDA1MzhjM2Q0NTEyN2MxNDJmNDk4NjQyNjlhMzhkZTQ5NjhjNzdmMDIwMTkxMDI1Mjc1ZjE0Y2JkOTc2In0.eyJhdWQiOiIxIiwianRpIjoiZjc0ZmU5OTRkOTE1YThmN2NiOWNkMDUzOGMzZDQ1MTI3YzE0MmY0OTg2NDI2OWEzOGRlNDk2OGM3N2YwMjAxOTEwMjUyNzVmMTRjYmQ5NzYiLCJpYXQiOjE1MDU3NzI0OTUsIm5iZiI6MTUwNTc3MjQ5NSwiZXhwIjoxNTM3MzA4NDk1LCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.cOcfPc3ZOeq4Hh6GU52BOjkICOncLeE9PJQQtIu-Xpsm2DAAbSYTGHS7twmcDSjcpVe7vy7xUMXpfkGAmtM1IzOagV7dVWq2TCreEm3ev0qrMKonB_82p8oAeYPImDyB2pxgiDWXA867SLhZ_14wtPc3wFYNYlesE2KGDmFX7i9oDnTfF9QolpcOBB77kkgwxWJu5V3Jjgcs0CUJGdZyTvATXwCyUC0alakC6UD23Qd9M83KDP00tCL5BeirMFUNEdzaMPS-107l6-q_y1psyPrczksfrVFc1kRfaxoHGwmjInkgTy0-ZLegwPtfXk01BDI-My8WQEUn8JcbhD3k3G4A7SmN0dGN04-q1Oh2DZOzAD0n6Ptf8rTCTWal6YOPotINAyqeGl9gvzuMoWWGSP3m7TtoGbhLOu-m-7smHwwUvzcUqWuHjHLP7zV3sKu0G0yseK5A8pWThwRS1HDI402EqIa1n3Q3iH8c5PC58MdDC1_zzZ-6D2VEOS5FFV6PcQaAh1xESjfM6GlAGxF45CJG1GE-RlfZ14QeH-tNLmG3VZKZvGtCOfrsyVgKjvdvL8D3CbjqNrFTxTzK9fAWTmTZWmKZQQZrMINsTtQ4-WMU7uKuEvIv8pZHkLC5g2G33POJ2LYhIyaQREWjSD6D-z8cpYgBcPCkpHvO3_agxr8"
                    },
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                        };
                    },
                    processResults: function (data, params) {
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        params.page = params.page || 1;

                        return {
                            results: data.data,
                            pagination: {
                                more: (params.page * 30) < data.total
                            }
                        };
                    },
                    cache: true
                },
                placeholder: '请搜索',
                escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            }
        }
    </script>
@endsection
