<?php
/**
 * Created by PhpStorm.
 * User: fuqunchao
 * Date: 2017/8/14
 * Time: 12:46
 */

namespace App\Repositories;


use App\AddressCode;
use App\AssocCode;
use App\BiogMain;
use App\Dynasty;
use App\EntryCode;
use App\EventCode;
use App\KinshipCode;
use App\NameList;
use App\OfficeCode;
use App\SocialInst;
use App\StatusCode;
use App\TextCode;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * Class BiogMainRepository
 * @package App\Repositories
 */
class BiogMainRepository
{
    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function byPersonId($id)
    {
        $basicinformation = BiogMain::withCount('sources', 'texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->find($id);
        return $basicinformation;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function simpleByPersonId($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->find($id);
        return $basicinformation;
    }

    public function byIdWithAddr($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->with('biog_addresses')->find($id);
        return $basicinformation;
    }

    public function byIdWithAlt($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->with('altnames')->find($id);
        return $basicinformation;
    }

    public function byIdWithText($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->with('texts', 'texts_role')->find($id);
        return $basicinformation;
    }

    public function byIdWithOff($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->with('offices', 'offices_addr')->find($id);
        return $basicinformation;
    }
    public function byIdWithEntries($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->with('entries')->find($id);
        return $basicinformation;
    }
    public function byIdWithStatuses($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->with('statuses')->find($id);
        return $basicinformation;
    }
    public function byIdWithAssoc($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->with('assoc', 'assoc_name')->find($id);
        return $basicinformation;
    }
    public function byIdWithKinship($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->with('kinship', 'kinship_name')->find($id);
        return $basicinformation;
    }
    public function byIdWithPossession($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->with('possession')->find($id);
        return $basicinformation;
    }

    public function byIdWithSocialInst($id)
    {
        $basicinformation = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->withCount('sources','texts', 'biog_addresses', 'altnames', 'offices', 'entries', 'statuses', 'kinship', 'assoc', 'possession', 'inst', 'events')->with('inst', 'inst_name')->find($id);
        return $basicinformation;
    }

    public function byQuery($query)
    {
        $params = explode(' ', $query);
//        dump($params);
        /**
         * 这里我想到了两种方法，
         * 第一种：建索引表，跟搜索引擎一样，每个人物的有一个提取出一个关键特征向量，用二进制表示，把用户的查询条件转换成相应的特征向量，通过与或匹配
         * 第一种方法的优缺点都很明显，优点是搜索功能可以很强大，缺点是工程量比较大
         *
         * 第二种：先定义好查询的范围，再查
         *
         */
        $basicinformation = BiogMain::whereIn('c_name_chn', $params)->simplePaginate(5);
        $basicinformation->withPath(url('v1/api/biog?query='.$query));
        return $basicinformation;
    }

    /**
     * @param $request
     * @param $id
     */
    public function updateById($request, $id)
    {
        $data = $request->all();
        $c_name_chn = $request->c_surname_chn.$request->c_mingzi_chn;
        $c_name = $request->c_surname.' '.$request->c_mingzi;
        $c_name_proper = $request->c_surname_proper.' '.$request->c_mingzi_proper;
        $c_name_rm = $request->c_surname_rm.' '.$request->c_mingzi_rm;
        $data['c_name_chn'] = $c_name_chn;
        $data['c_name'] = $c_name;
        $data['c_name_proper'] = $c_name_proper;
        $data['c_name_rm'] = $c_name_rm;
        $data['c_female'] = (int)($data['c_female']);
        $data['c_by_intercalary'] = (int)($data['c_by_intercalary']);
        $data['c_dy_intercalary'] = (int)($data['c_dy_intercalary']);
        $data = (new ToolsRepository)->timestamp($data);
        $biogbasicinformation = BiogMain::find($id);
        $biogbasicinformation->update($data);
        (new OperationRepository())->store(Auth::id(), $id, 3, 'BIOG_MAIN', $biogbasicinformation->tts_sysno, $data);
    }

    /**
     * @param $request
     * @param $num
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function namesByQuery(Request $request, $num=20)
    {
        if ($temp = $request->num){
            $num = $temp;
        }
        if (!$request->q){
            return BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->paginate($num);
        }
        $names = BiogMain::select(['c_personid', 'c_name_chn', 'c_name'])->where('c_name_chn', 'like', '%'.$request->q.'%')->orWhere('c_name', 'like', '%'.$request->q.'%')->orWhere('c_personid', $request->q)->paginate($num);
        $names->appends(['q' => $request->q])->links();
        return $names;
    }

    /**
     * @param $id_
     * @return array
     */
    public function textById($id_){
        $row = DB::table('TEXT_DATA')->where('tts_sysno', $id_)->first();
        $text = null;
        if($row->c_textid || $row->c_textid === 0) {
            $text_ = TextCode::find($row->c_textid);
            $text = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;

        }
        $text_str = null;
        if($row->c_source || $row->c_source === 0) {
            $text_ = TextCode::find($row->c_source);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;
        }
        return ['row' => $row, 'text' => $text, 'text_str' => $text_str];
    }

    public function textUpdateById( )
    {

    }

    public function officeById($id)
    {
        $row = DB::table('POSTED_TO_OFFICE_DATA')->where('tts_sysno', $id)->first();
        $text_str = null;
        if($row->c_source || $row->c_source === 0) {
            $text_ = TextCode::find($row->c_source);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;

        }
        $office_str = null;
        if($row->c_office_id || $row->c_office_id === 0) {
            $text_ = OfficeCode::find($row->c_office_id);
            $dy = Dynasty::where('c_dy', $text_->c_dy)->first()->c_dynasty_chn;
            $office_str = $text_->c_office_id." ".$text_->c_office_pinyin." ".$text_->c_office_chn." ".$dy;
        }
        $posting_str = null;
//        dd($row->c_inst_name_code);
        if($row->c_inst_code || $row->c_inst_code === 0) {
            $text_ = SocialInst::find($row->c_inst_code);
            $posting_str = $text_->c_inst_name_code." ".$text_->c_inst_name_py." ".$text_->c_inst_name_hz;
        }
//        dd($posting_str);
        $addr_ = DB::table('POSTED_TO_ADDR_DATA')->where('c_personid', $row->c_personid)->where('c_posting_id', $row->c_posting_id)->get();
        $addr_str = [];
        foreach ($addr_ as $key=>$value) {
            $id_ = $value->c_addr_id == 0 ? -999 : $value->c_addr_id;
            $item = [$id_, $this->addr_str($value->c_addr_id)];
            $addr_str[$key] = $item;
        }
        return ['row' => $row, 'text_str' => $text_str, 'office_str' => $office_str, 'posting_str' => $posting_str, 'addr_str' => $addr_str];
    }

    public function officeUpdateById(Request $request, $id, $c_personid)
    {
        $data = $request->all();
//        dd($data);
        $_id = $data['_id'];
        $_postingid = $data['_postingid'];
        $c_addr = $data['c_addr'];
        $_officeid = $data['_officeid']; //目前与officeid无关

        $this->insertAddr($c_addr, $_id, $_postingid, $_officeid);
        $data = array_except($data, ['_method', '_token', 'c_addr', '_id', '_postingid', '_officeid']);
        $data['c_fy_intercalary'] = (int)($data['c_fy_intercalary']);
        $data['c_ly_intercalary'] = (int)($data['c_ly_intercalary']);
        $data['c_office_id'] = $data['c_office_id'] == -999 ? '0' : $data['c_office_id'];
        $data['c_inst_code'] = $data['c_inst_code'] == -999 ? '0' : $data['c_inst_code'];
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data);
        DB::table('POSTED_TO_OFFICE_DATA')->where('tts_sysno',$id)->update($data);
        (new OperationRepository())->store(Auth::id(), $c_personid, 3, 'POSTED_TO_OFFICE_DATA', $id, $data);
    }

    public function officeStoreById(Request $request, $id)
    {
        $data = $request->all();
//        dd($data);
        $c_addr = $data['c_addr'];
        $data = array_except($data, ['_token', 'c_addr']);
        $data['c_fy_intercalary'] = (int)($data['c_fy_intercalary']);
        $data['c_ly_intercalary'] = (int)($data['c_ly_intercalary']);
        $data['tts_sysno'] = DB::table('POSTED_TO_OFFICE_DATA')->max('tts_sysno') + 1;
        $data['c_posting_id'] = DB::table('POSTED_TO_OFFICE_DATA')->max('c_posting_id') + 1;
        $data['c_personid'] = $id;
        $this->insertAddr($c_addr, $id, $data['c_posting_id'], $data['c_office_id']);
        $data = (new ToolsRepository)->timestamp($data, True);
        DB::table('POSTED_TO_OFFICE_DATA')->insert($data);
        (new OperationRepository())->store(Auth::id(), $id, 1, 'POSTED_TO_OFFICE_DATA', $data['tts_sysno'], $data);
        return $data['tts_sysno'];
    }

    public function officeDeleteById($id, $c_personid)
    {
        $row = DB::table('POSTED_TO_OFFICE_DATA')->where('tts_sysno', $id)->first();
        DB::table('POSTED_TO_OFFICE_DATA')->where('tts_sysno', $id)->delete();
        DB::table('POSTED_TO_ADDR_DATA')->where('c_personid', $row->c_personid)->where('c_posting_id', $row->c_posting_id)->delete();
        (new OperationRepository())->store(Auth::id(), $c_personid, 4, 'POSTED_TO_OFFICE_DATA', $id, $row);
    }

    public function entryById($id)
    {
        $row = DB::table('ENTRY_DATA')->where('tts_sysno', $id)->first();
        $text_str = null;
        if($row->c_source || $row->c_source === 0) {
            $text_ = TextCode::find($row->c_source);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;
        }
        $entry_str = null;
        if($row->c_entry_code || $row->c_entry_code === 0) {
            $text_ = EntryCode::find($row->c_entry_code);
            $entry_str = $text_->c_entry_code." ".$text_->c_entry_desc_chn." ".$text_->c_entry_desc;
        }
        $addr_str = null;
        if($row->c_entry_addr_id || $row->c_entry_addr_id === 0) {
            $text_ = AddressCode::find($row->c_entry_addr_id);
            $addr_str = $text_->c_addr_id." ".$text_->c_name_chn." ".$text_->c_name;
        }
        $kin_str = null;
        if($row->c_kin_code || $row->c_kin_code === 0) {
            $text_ = KinshipCode::find($row->c_kin_code);
            $kin_str = $text_->c_kin_code." ".$text_->c_kinrel_chn." ".$text_->c_kinrel;
        }
        $assoc_str = null;
        if($row->c_assoc_code || $row->c_assoc_code === 0) {
            $text_ = AssocCode::find($row->c_assoc_code);
            $assoc_str = $text_->c_assoc_code." ".$text_->c_assoc_desc_chn." ".$text_->c_assoc_desc;
        }
        $inst_str = null;
        if($row->c_inst_code || $row->c_inst_code === 0) {
            $text_ = SocialInst::find($row->c_inst_code);
            $inst_str = $text_->c_inst_code." ".$text_->c_inst_name_py." ".$text_->c_inst_name_hz;
        }
        return ['row' => $row, 'text_str' => $text_str, 'entry_str' => $entry_str, 'addr_str' => $addr_str, 'kin_str' => $kin_str, 'assoc_str' => $assoc_str, 'inst_str' => $inst_str];
    }

    public function entryUpdateById(Request $request, $id, $c_personid)
    {
        $data = $request->all();
        $data = array_except($data, ['_method', '_token']);
        $data['c_entry_code'] = $data['c_entry_code'] == -999 ? '0' : $data['c_entry_code'];
        $data['c_entry_addr_id'] = $data['c_entry_addr_id'] == -999 ? '0' : $data['c_entry_addr_id'];
        $data['c_kin_code'] = $data['c_kin_code'] == -999 ? '0' : $data['c_kin_code'];
        $data['c_assoc_code'] = $data['c_assoc_code'] == -999 ? '0' : $data['c_assoc_code'];
        $data['c_inst_code'] = $data['c_inst_code'] == -999 ? '0' : $data['c_inst_code'];
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data);
        DB::table('ENTRY_DATA')->where('tts_sysno',$id)->update($data);
        (new OperationRepository())->store(Auth::id(), $c_personid, 3, 'ENTRY_DATA', $id, $data);
    }

    public function entryStoreById(Request $request, $id)
    {
        $data = $request->all();
        $data = array_except($data, ['_token']);
        $data['tts_sysno'] = DB::table('ENTRY_DATA')->max('tts_sysno') + 1;
        $data['c_personid'] = $id;
        $data['c_entry_code'] = $data['c_entry_code'] == -999 ? '0' : $data['c_entry_code'];
        $data['c_entry_addr_id'] = $data['c_entry_addr_id'] == -999 ? '0' : $data['c_entry_addr_id'];
        $data['c_kin_code'] = $data['c_kin_code'] == -999 ? '0' : $data['c_kin_code'];
        $data['c_assoc_code'] = $data['c_assoc_code'] == -999 ? '0' : $data['c_assoc_code'];
        $data['c_inst_code'] = $data['c_inst_code'] == -999 ? '0' : $data['c_inst_code'];
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data, True);
        DB::table('ENTRY_DATA')->insert($data);
        (new OperationRepository())->store(Auth::id(), $id, 1, 'ENTRY_DATA', $data['tts_sysno'], $data);
        return $data['tts_sysno'];
    }

    public function entryDeleteById($id, $c_personid)
    {
        $row = DB::table('ENTRY_DATA')->where('tts_sysno', $id)->first();
        DB::table('ENTRY_DATA')->where('tts_sysno', $id)->delete();
        (new OperationRepository())->store(Auth::id(), $c_personid, 4, 'ENTRY_DATA', $id, $row);
    }

    public function statuseById($id)
    {
        $row = DB::table('STATUS_DATA')->where('tts_sysno', $id)->first();
        $text_str = null;
        if($row->c_source || $row->c_source === 0) {
            $text_ = TextCode::find($row->c_source);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;
        }
        $statuse_str = null;
        if($row->c_status_code || $row->c_status_code === 0) {
            $text_ = StatusCode::find($row->c_status_code);
            $statuse_str = $text_->c_status_code." ".$text_->c_status_desc_chn." ".$text_->c_status_desc;
        }
        return ['row' => $row, 'text_str' => $text_str, 'statuse_str' => $statuse_str];
    }

    public function statuseUpdateById(Request $request, $id, $c_personid)
    {
        $data = $request->all();
        $data = array_except($data, ['_token', '_method']);
        $data['c_status_code'] = $data['c_status_code'] == -999 ? '0' : $data['c_status_code'];
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data);
        DB::table('STATUS_DATA')->where('tts_sysno',$id)->update($data);
        (new OperationRepository())->store(Auth::id(), $c_personid, 3, 'STATUS_DATA', $id, $data);
    }

    public function statuseStoreById(Request $request, $id)
    {
        $data = $request->all();
        $data = array_except($data, ['_token']);
        $data['tts_sysno'] = DB::table('STATUS_DATA')->max('tts_sysno') + 1;
        $data['c_personid'] = $id;
        $data['c_status_code'] = $data['c_status_code'] == -999 ? '0' : $data['c_status_code'];
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data, True);
        DB::table('STATUS_DATA')->insert($data);
        (new OperationRepository())->store(Auth::id(), $data['c_personid'], 1, 'STATUS_DATA', $data['tts_sysno'], $data);
        return $data['tts_sysno'];
    }

    public function statuseDeleteById($id, $c_personid)
    {
        $row = DB::table('STATUS_DATA')->where('tts_sysno', $id)->first();
        DB::table('STATUS_DATA')->where('tts_sysno', $id)->delete();
        (new OperationRepository())->store(Auth::id(), $c_personid, 4, 'STATUS_DATA', $id, $row);
    }

    public function kinshipById($id)
    {
        $row = DB::table('KIN_DATA')->where('tts_sysno', $id)->first();
        $text_str = null;
        if($row->c_source || $row->c_source === 0) {
            $text_ = TextCode::find($row->c_source);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;
        }
        $kin_str = null;
        if($row->c_kin_code || $row->c_kin_code === 0) {
            $text_ = KinshipCode::find($row->c_kin_code);
            $kin_str = $text_->c_status_code." ".$text_->c_kinrel_chn." ".$text_->c_kinrel;
        }
        $biog_str = null;
        $kinpair_str = null;
        if($row->c_kin_id || $row->c_kin_id === 0) {
            $text_ = BiogMain::find($row->c_kin_id);
            $biog_str = $text_->c_personid." ".$text_->c_name_chn." ".$text_->c_name;
            $k_p_code = DB::table('KIN_DATA')->where([['c_kin_id',$row->c_personid], ['c_personid', $row->c_kin_id]])->first()->c_kin_code;
            $text_ = KinshipCode::find($k_p_code);
            $kinpair_str = $text_->c_status_code." ".$text_->c_kinrel_chn." ".$text_->c_kinrel;
        }

//        dd($biog_str);
        return ['row' => $row, 'text_str' => $text_str, 'kin_str' => $kin_str, 'biog_str' => $biog_str, 'kinpair_str' => $kinpair_str, 'k_p_code' => $k_p_code];
    }

    public function kinshipUpdateById(Request $request, $id, $id_)
    {
        $data = $request->all();

        $kin_pair = $data['c_kinship_pair'];
        $kin_id = $data['c_kin_id'];
        $old_kin_id = DB::table('KIN_DATA')->where('tts_sysno',$id_)->first()->c_kin_id;
        $data = array_except($data, ['_token', '_method', 'c_kinship_pair']);
        $data['c_kin_code'] = $data['c_kin_code'] == -999 ? '0' : $data['c_kin_code'];
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data);
//        dump($data);
        DB::table('KIN_DATA')->where('tts_sysno',$id_)->update($data);
        (new OperationRepository())->store(Auth::id(), $id, 3, 'KIN_DATA', $id_, $data);
        $data['c_kin_code'] = $kin_pair;
        $data['c_personid'] = $kin_id;
        $data = array_except($data, ['c_kin_id']);
//        dump($data);
//        dd(DB::table('KIN_DATA')->where([['c_kin_id',$id], ['c_personid', $old_kin_id]])->first());
        DB::table('KIN_DATA')->where([['c_kin_id',$id], ['c_personid', $old_kin_id]])->update($data);
    }

    public function kinshipStoreById(Request $request, $id)
    {
        $data = $request->all();
        $kin_pair = $data['c_kinship_pair'];
        $data = array_except($data, ['_token', 'c_kinship_pair']);
        $data['tts_sysno'] = DB::table('KIN_DATA')->max('tts_sysno') + 1;
        $tts = $data['tts_sysno'];
        $data['c_personid'] = $id;
        $data['c_kin_code'] = $data['c_kin_code'] == -999 ? '0' : $data['c_kin_code'];
        $data['c_kin_id'] = $data['c_kin_id'] == -999 ? '0' : $data['c_kin_id'];
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data, True);
        DB::table('KIN_DATA')->insert($data);
        (new OperationRepository())->store(Auth::id(), $id, 1, 'KIN_DATA', $data['tts_sysno'], $data);
        $data['tts_sysno'] += 1;
        $data['c_kin_code'] = $kin_pair;
        $data['c_personid'] = $data['c_kin_id'];
        $data['c_kin_id'] = $id;
        DB::table('KIN_DATA')->insert($data);
        return $tts;
    }

    public function kinshipDeleteById($id, $c_personid)
    {
        $operationRepository = new OperationRepository();
        $row = DB::table('KIN_DATA')->where('tts_sysno', $id)->first();
        (new OperationRepository())->store(Auth::id(), $c_personid, 4, 'KIN_DATA', $id, $row);
        $row = DB::table('KIN_DATA')->where([['c_kin_id',$row->c_personid], ['c_personid', $row->c_kin_id]])->first();
        DB::table('KIN_DATA')->where('tts_sysno', $id)->delete();
        DB::table('KIN_DATA')->where('tts_sysno', $row->tts_sysno)->delete();
    }

    public function possessionById($id)
    {
        $row = DB::table('POSSESSION_DATA')->where('c_possession_record_id', $id)->first();
        $text_str = null;
        if($row->c_source || $row->c_source === 0) {
            $text_ = TextCode::find($row->c_source);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;

        }

        $addr_ = DB::table('POSSESSION_ADDR')->where('c_possession_record_id', $id)->get();
//        dd($addr_);
        $addr_str = [];
        foreach ($addr_ as $key=>$value) {
            $id_ = $value->c_addr_id == 0 ? -999 : $value->c_addr_id;
            $item = [$id_, $this->addr_str($value->c_addr_id)];
            $addr_str[$key] = $item;
        }

        return ['row' => $row, 'text_str' => $text_str, 'addr_str' => $addr_str];
    }

    public function possessionUpdateById(Request $request, $id, $id_)
    {
        $data = $request->all();
        $this->insertAddrPo($data['c_addr_id'], $id_, $id);
        $data = array_except($data, ['_method', '_token', 'c_addr_id']);
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data);
        DB::table('POSSESSION_DATA')->where('c_possession_record_id',$id_)->update($data);
        (new OperationRepository())->store(Auth::id(), $id, 3, 'POSSESSION_DATA', $id_, $data);
    }

    public function possessionStoreById(Request $request, $id)
    {
        $data = $request->all();
        $data['c_possession_record_id'] = DB::table('POSSESSION_DATA')->max('c_possession_record_id') + 1;
        $data['c_personid'] = $id;
        $this->insertAddrPo($data['c_addr_id'], $data['c_possession_record_id'], $data['c_personid']);
        $data = array_except($data, ['_token', 'c_addr_id']);
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data, True);
        DB::table('POSSESSION_DATA')->insert($data);
        (new OperationRepository())->store(Auth::id(), $id, 1, 'POSSESSION_DATA', $data['c_possession_record_id'], $data);
        return $data['c_possession_record_id'];
    }

    public function possessionDeleteById($id, $c_personid)
    {
        $row = DB::table('POSSESSION_DATA')->where('c_possession_record_id', $id)->first();
        DB::table('POSSESSION_DATA')->where('c_possession_record_id', $id)->delete();
        DB::table('POSSESSION_ADDR')->where('c_possession_record_id', $row->c_possession_record_id)->delete();
        (new OperationRepository())->store(Auth::id(), $c_personid, 4, 'POSSESSION_DATA', $id, $row);
    }

    public function socialInstById($id)
    {
        $row = DB::table('BIOG_INST_DATA')->where('tts_sysno', $id)->first();
        $text_str = null;
        if($row->c_source || $row->c_source === 0) {
            $text_ = TextCode::find($row->c_source);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;

        }
        $inst_str = null;
        if($row->c_inst_name_code || $row->c_inst_name_code === 0) {
            $text_ = SocialInst::find($row->c_inst_name_code);
//            dd($text_);
            $inst_str = $text_->c_inst_name_code." ".$text_->c_inst_name_hz." ".$text_->c_inst_name_py;

        }
        return ['row' => $row, 'text_str' => $text_str, 'inst_str' => $inst_str];
    }

    public function socialInstUpdateById(Request $request, $id_, $c_personid)
    {
        $data = $request->all();
        $data = array_except($data, ['_method', '_token']);
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data);
        DB::table('BIOG_INST_DATA')->where('tts_sysno',$id_)->update($data);
        (new OperationRepository())->store(Auth::id(), $c_personid, 3, 'BIOG_INST_DATA', $id_, $data);
    }

    public function socialInstStoreById(Request $request, $id)
    {
        $data = $request->all();
        $data['c_personid'] = $id;
        $data = array_except($data, ['_token']);
        $data['c_source'] = $data['c_source'] == -999 ? '0' : $data['c_source'];
        $data = (new ToolsRepository)->timestamp($data, True);
        $tts = DB::table('BIOG_INST_DATA')->insertGetId($data);
        (new OperationRepository())->store(Auth::id(), $id, 1, 'BIOG_INST_DATA', $tts, $data);
        return $tts;
    }

    public function socialInstDeleteById($id, $c_personid)
    {
        $row = DB::table('BIOG_INST_DATA')->where('tts_sysno', $id)->first();
        DB::table('BIOG_INST_DATA')->where('tts_sysno', $id)->delete();
        (new OperationRepository())->store(Auth::id(), $c_personid, 4, 'BIOG_INST_DATA', $id, $row);
    }

    public function eventById($id)
    {
        $row = DB::table('EVENTS_DATA')->where('tts_sysno', $id)->first();
        $text_str = null;
        if($row->c_source || $row->c_source === 0) {
            $text_ = TextCode::find($row->c_source);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;

        }
        $addr_ = DB::table('EVENTS_ADDR')->where('c_event_record_id', $row->c_event_record_id)->get();
        $addr_str = [];
        foreach ($addr_ as $key=>$value) {
            $id_ = $value->c_addr_id == 0 ? -999 : $value->c_addr_id;
            $item = [$id_, $this->addr_str($value->c_addr_id)];
            $addr_str[$key] = $item;
        }
        $event_str = null;
        if($row->c_event_code || $row->c_event_code === 0) {
            $text_ = EventCode::find($row->c_event_code);
            $event_str = $text_->c_event_code." ".$text_->c_event_name_chn." ".$text_->c_event_name;
        }
        return ['row' => $row, 'text_str' => $text_str, 'addr_str' => $addr_str, 'event_str' => $event_str];
    }

    public function eventUpdateById(Request $request, $id, $id_)
    {
        $data = $request->all();
        $data = $this->formatSelect($data);
        $this->insertAddrEvent($data['c_addr_id'], $data['c_event_record_id'], $id);
        $data = array_except($data, ['_method', '_token', 'c_addr_id']);
        $data['c_intercalary'] = (int)($data['c_intercalary']);
        $data = (new ToolsRepository)->timestamp($data);
        DB::table('EVENTS_DATA')->where('tts_sysno',$id_)->update($data);
        (new OperationRepository())->store(Auth::id(), $id, 3, 'EVENTS_DATA', $id_, $data);
    }

    public function eventStoreById(Request $request, $id)
    {
        $data = $request->all();
        $data = $this->formatSelect($data);
        $data['c_personid'] = $id;
        $data['c_event_record_id'] = DB::table('EVENTS_DATA')->max('c_event_record_id') + 1;
        $this->insertAddrEvent($data['c_addr_id'], $data['c_event_record_id'], $id);
        $data = array_except($data, ['_token', 'c_addr_id']);
        $data['tts_sysno'] = DB::table('EVENTS_DATA')->max('tts_sysno') + 1;
        $data['c_intercalary'] = (int)($data['c_intercalary']);
        $data = (new ToolsRepository)->timestamp($data, True);
        DB::table('EVENTS_DATA')->insert($data);
        (new OperationRepository())->store(Auth::id(), $id, 1, 'EVENTS_DATA', $data['tts_sysno'], $data);
        return $data['tts_sysno'];
    }

    public function eventDeleteById($id, $c_personid)
    {
        $row = DB::table('EVENTS_DATA')->where('tts_sysno', $id)->first();
        DB::table('EVENTS_DATA')->where('tts_sysno', $id)->delete();
        DB::table('EVENTS_ADDR')->where('c_event_record_id', $row->c_event_record_id)->delete();
        (new OperationRepository())->store(Auth::id(), $c_personid, 4, 'EVENTS_DATA', $id, $row);
    }

    public function assocById($id)
    {
        $row = DB::table('ASSOC_DATA')->where('tts_sysno', $id)->first();
        $text_str = null;
        if($row->c_source || $row->c_source === 0) {
            $text_ = TextCode::find($row->c_source);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;
        }
        $kin_code = null;
        if($row->c_kin_code || $row->c_kin_code === 0) {
            $text_ = KinshipCode::find($row->c_kin_code);
            $kin_code = $text_->c_status_code." ".$text_->c_kinrel_chn." ".$text_->c_kinrel;
        }
        $kin_id = null;
        if($row->c_kin_id || $row->c_kin_id === 0) {
            $text_ = BiogMain::find($row->c_kin_id);
            $kin_id = $text_->c_personid." ".$text_->c_name_chn." ".$text_->c_name;
        }
        $assoc_code = null;
        if($row->c_assoc_code || $row->c_assoc_code === 0) {
            $text_ = AssocCode::find($row->c_assoc_code);
            $assoc_code = $text_->c_assoc_code." ".$text_->c_assoc_desc_chn." ".$text_->c_assoc_desc;
        }
        $assoc_id = null;
        if($row->c_assoc_id || $row->c_assoc_id === 0) {
            $text_ = BiogMain::find($row->c_assoc_id);
            $assoc_id = $text_->c_personid." ".$text_->c_name_chn." ".$text_->c_name;
        }
        $assoc_kin_code = null;
        if($row->c_assoc_kin_code || $row->c_assoc_kin_code === 0) {
            $text_ = KinshipCode::find($row->c_assoc_kin_code);
            $assoc_kin_code = $text_->c_status_code." ".$text_->c_kinrel_chn." ".$text_->c_kinrel;
        }
        $assoc_kin_id = null;
        if($row->c_assoc_kin_id || $row->c_assoc_kin_id === 0) {
            $text_ = BiogMain::find($row->c_assoc_kin_id);
            $assoc_kin_id = $text_->c_personid." ".$text_->c_name_chn." ".$text_->c_name;
        }
        $tertiary_personid = null;
        if($row->c_tertiary_personid || $row->c_tertiary_personid === 0) {
            $text_ = BiogMain::find($row->c_tertiary_personid);
            $tertiary_personid = $text_->c_personid." ".$text_->c_name_chn." ".$text_->c_name;
        }
        $addr_id = null;
        if($row->c_addr_id || $row->c_addr_id === 0) {
            $text_ = AddressCode::find($row->c_addr_id);
            $addr_id = $text_->c_addr_id." ".$text_->c_name_chn." ".$text_->c_name;
        }
        $inst_code = null;
        if($row->c_inst_code || $row->c_inst_code === 0) {
            $text_ = SocialInst::find($row->c_inst_code);
            $inst_code = $text_->c_inst_name_code." ".$text_->c_inst_name_hz." ".$text_->c_inst_name_py;
        }
        return ['row' => $row, 'text_str' => $text_str, 'kin_code' => $kin_code, 'kin_id' => $kin_id,
            'assoc_code' => $assoc_code, 'assoc_id' => $assoc_id, 'assoc_kin_code' => $assoc_kin_code, 'assoc_kin_id' => $assoc_kin_id,
            'tertiary_personid' => $tertiary_personid, 'addr_id' => $addr_id, 'inst_code' => $inst_code];
    }

    public function assocUpdateById(Request $request, $id, $c_personid)
    {
        $data = $request->all();
        $data = $this->formatSelect($data);
        $assoc_pair = $data['c_assocship_pair'];
        $assoc_id = $data['c_assoc_id'];
        $data = array_except($data, ['_method', '_token', 'c_assocship_pair', 'c_assoc_id']);
        $data['c_assoc_intercalary'] = (int)($data['c_assoc_intercalary']);
        $data = (new ToolsRepository)->timestamp($data);
        DB::table('ASSOC_DATA')->where('tts_sysno',$id)->update($data);
        (new OperationRepository())->store(Auth::id(), $c_personid, 3, 'ASSOC_DATA', $id, $data);
        $data['c_assoc_code'] = $assoc_pair;
        DB::table('ASSOC_DATA')->where([['c_assoc_id',$id], ['c_personid', $assoc_id]])->update($data);
    }

    public function assocStoreById(Request $request, $id)
    {
        $data = $request->all();
        $data = $this->formatSelect($data);
        $assoc_pair = $data['c_assocship_pair'];
        $data['c_personid'] = $id;
        $data = array_except($data, ['_token', 'c_assocship_pair']);
        $data['tts_sysno'] = DB::table('ASSOC_DATA')->max('tts_sysno') + 1;
        $data['c_assoc_intercalary'] = (int)($data['c_assoc_intercalary']);
        $data = (new ToolsRepository)->timestamp($data, True);
        DB::table('ASSOC_DATA')->insert($data);
        (new OperationRepository())->store(Auth::id(), $id, 1, 'ASSOC_DATA', $data['tts_sysno'], $data);
        $data['tts_sysno'] += 1;
        $data['c_assoc_code'] = $assoc_pair;
        $data['c_personid'] = $data['c_assoc_id'];
        $data['c_assoc_id'] = $id;
        DB::table('ASSOC_DATA')->insert($data);
        return $data['tts_sysno'];
    }

    public function assocDeleteById($id, $c_personid)
    {
        $row = DB::table('ASSOC_DATA')->where('tts_sysno', $id)->first();
        DB::table('ASSOC_DATA')->where('tts_sysno', $id)->delete();
        DB::table('ASSOC_DATA')->where('tts_sysno', $row->tts_sysno)->delete();
        (new OperationRepository())->store(Auth::id(), $c_personid, 4, 'ASSOC_DATA', $id, $row);
    }

    public function sourceById($id, $text_id)
    {
        $row = DB::table('BIOG_SOURCE_DATA')->where([['c_personid', $id], ['c_textid', $text_id]])->first();
        $text_str = null;
        if($row->c_textid || $row->c_textid === 0) {
            $text_ = TextCode::find($row->c_textid);
            $text_str = $text_->c_textid." ".$text_->c_title." ".$text_->c_title_chn;
        }
        return ['row' => $row, 'text_str' => $text_str];
    }

    public function sourceUpdateById(Request $request, $id, $text_id)
    {
        $data = $request->all();
        $data = array_except($data, ['_method', '_token']);
        $data['c_personid'] = $id;
        $data['c_main_source'] = (int)$data['c_main_source'];
        $data['c_self_bio'] = (int)$data['c_self_bio'];
        DB::table('BIOG_SOURCE_DATA')->where([['c_personid', $id], ['c_textid', $text_id]])->update($data);
        (new OperationRepository())->store(Auth::id(), $id, 3, 'BIOG_SOURCE_DATA', $text_id, $data);
        return $data['c_textid'];
    }

    public function sourceStoreById(Request $request, $id)
    {
        $data = $request->all();
        $data = array_except($data, ['_token']);
        $data['c_personid'] = $id;
        $data['c_main_source'] = (int)$data['c_main_source'];
        $data['c_self_bio'] = (int)$data['c_self_bio'];
        DB::table('BIOG_SOURCE_DATA')->insert($data);
        (new OperationRepository())->store(Auth::id(), $id, 1, 'BIOG_SOURCE_DATA', $data['c_textid'], $data);
        return $data['c_textid'];
    }

    public function sourceDeleteById($id, $id_)
    {
        $row = DB::table('BIOG_SOURCE_DATA')->where([['c_personid', $id], ['c_textid', $id_]])->first();
        DB::table('BIOG_SOURCE_DATA')->where([['c_personid', $id], ['c_textid', $id_]])->delete();
        (new OperationRepository())->store(Auth::id(), $id, 4, 'BIOG_SOURCE_DATA', $id, $row);
    }

    protected function addr_str($id)
    {
        $row = AddressCode::find($id);
        $belongs = $row->belongs1_Name." ".$row->belongs2_Name." ".$row->belongs3_Name." ".$row->belongs4_Name." ".$row->belongs5_Name;
        return $row->c_addr_id.' '.$row->c_name.' '.$row->c_name_chn.' '.trim($belongs);
    }

    protected function insertAddr(Array $c_addr, $_id, $_postingid, $_officeid)
    {
        DB::table('POSTED_TO_ADDR_DATA')->where('c_personid', $_id)->where('c_posting_id', $_postingid)->delete();
        foreach ($c_addr as $item) {
            DB::table('POSTED_TO_ADDR_DATA')->insert(
                [
                    'c_personid' => $_id,
                    'c_posting_id' => $_postingid,
                    'c_office_id' => $_officeid,
                    'c_addr_id' => $item == -999 ? 0 : $item
                ]
            );
        }
    }

    protected function insertAddrPo(Array $c_addr_id, $c_possession_record_id, $c_personid)
    {
        DB::table('POSSESSION_ADDR')->where('c_possession_record_id', $c_possession_record_id)->delete();
        foreach ($c_addr_id as $item) {
            DB::table('POSSESSION_ADDR')->insert(
                [
                    'c_personid' => $c_personid,
                    'c_possession_record_id' => $c_possession_record_id,
                    'c_addr_id' => $item == -999 ? 0 : $item
                ]
            );
        }
    }

    protected function insertAddrEvent(Array $c_addr_id, $c_event_record_id, $c_personid)
    {
        DB::table('EVENTS_ADDR')->where('c_event_record_id', $c_event_record_id)->delete();
        foreach ($c_addr_id as $item) {
            DB::table('EVENTS_ADDR')->insert(
                [
                    'c_personid' => $c_personid,
                    'c_event_record_id' => $c_event_record_id,
                    'c_addr_id' => $item == -999 ? 0 : $item
                ]
            );
        }
    }

    protected function formatSelect(Array $array)
    {
        foreach ($array as $key => $value){
            if ($value == -999) $array[$key] = 0;
        }
        return $array;
    }

}