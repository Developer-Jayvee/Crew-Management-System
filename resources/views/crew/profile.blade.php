  <div id="profile-details px-3 text">
      <div class="row">
          <div class="col-lg-12">
              <p class="text-left fw-bolder ">&nbsp;</p>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-4 fw-bold" v-if="user.userprofile.LName">@{{ user.userprofile.LName }}</div>
          <div class="col-lg-4 fw-bold" v-if="user.userprofile.FName">@{{ user.userprofile.FName }}</div>
          <div class="col-lg-4 fw-bold" v-if="user.userprofile.MName">@{{ user.userprofile.MName }}</div>
      </div>
      <div class="row  fst-italic">
          <div class="col-lg-4 border-top">Last</div>
          <div class="col-lg-4 border-top">First</div>
          <div class="col-lg-4 border-top">Middle</div>
      </div>
      <div class="row">
          <div class="col-lg-12">
              <p class="text-left fw-bolder ">&nbsp;</p>
          </div>
      </div>
      <div class="row mt-3">
          <div class="col-lg-9 fw-bold" v-if="user.userprofile.BDate">@{{ user.userprofile.BDate }}</div>
          <div class="col-lg-3 fw-bold" v-if="user.userprofile.Age">@{{ user.userprofile.Age }}</div>
      </div>

      <div class="row pt-0 mt-0 fst-italic ">
          <div class="col-lg-9  border-top ">Birthdate</div>
          <div class="col-lg-3 border-top">Age</div>
      </div>
      <div class="row">
          <div class="col-lg-12">
              <p class="text-left fw-bolder ">&nbsp;</p>
          </div>
      </div>

      <div class="row mt-3">
          <div class="col-lg-4 fw-bold" v-if="user.userprofile.Weight">@{{ user.userprofile.Weight }}</div>
          <div class="col-lg-4 fw-bold" v-if="user.userprofile.Height">@{{ user.userprofile.Height }}</div>
          <div class="col-lg-4 fw-bold" v-if="bmi">@{{ bmi }}</div>
      </div>

      <div class="row pt-0 mt-0 fst-italic ">
          <div class="col-lg-4 border-top">Weight</div>
          <div class="col-lg-4 border-top">Height</div>
          <div class="col-lg-4 border-top">BMI</div>
      </div>

      <div class="row">
          <div class="col-lg-12">
              <p class="text-left fw-bolder ">&nbsp;</p>
          </div>
      </div>
      <div class="row mt-3">
          <div class="col-lg-12 fw-bold" v-if="user.userprofile.profile_rank">@{{ user.userprofile.profile_rank.RankDescription }}</div>
      </div>

      <div class="row pt-0 mt-0 fst-italic ">
          <div class="col-lg-12 border-top ">Rank</div>
      </div>
      <div class="row">
          <div class="col-lg-12">
              <p class="text-left fw-bolder ">&nbsp;</p>
          </div>
      </div>
      <div class="row mt-3">
          <div class="col-lg-12 fw-bold" v-if="user.userprofile.Address">
              @{{ user.userprofile.Address }}
          </div>
      </div>

      <div class="row pt-0 mt-0 fst-italic ">
          <div class="col-lg-12 border-top ">Address</div>
      </div>
  </div>
