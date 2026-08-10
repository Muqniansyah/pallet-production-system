<?php

use App\Models\User;
use App\Models\PalletRequest;
use App\Models\Pesanan;
use App\Models\MeetingRequest;
use App\Models\Kunjungan;
use App\Models\Hpp;
use App\Models\ProdukKayu;
use App\Models\StokKayu;
use App\Models\PaletDesign;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// ═══════════════════════════════════════════
// USER — relasi model User
// ═══════════════════════════════════════════

test('user memiliki relasi hasMany ke palletRequests', function () {
    $user = new User();
    expect($user->palletRequests())->toBeInstanceOf(HasMany::class);
});

test('user memiliki relasi hasMany ke pesanan', function () {
    $user = new User();
    expect($user->pesanan())->toBeInstanceOf(HasMany::class);
});

test('user memiliki relasi hasMany ke meetings', function () {
    $user = new User();
    expect($user->meetings())->toBeInstanceOf(HasMany::class);
});

test('user memiliki relasi hasMany ke kunjungan', function () {
    $user = new User();
    expect($user->kunjungan())->toBeInstanceOf(HasMany::class);
});

// ═══════════════════════════════════════════
// PALLET REQUEST — relasi model PalletRequest
// ═══════════════════════════════════════════

test('palletRequest memiliki relasi belongsTo ke user sebagai client', function () {
    $palletRequest = new PalletRequest();
    expect($palletRequest->client())->toBeInstanceOf(BelongsTo::class);
});

test('palletRequest memiliki relasi hasOne ke pesanan', function () {
    $palletRequest = new PalletRequest();
    expect($palletRequest->pesanan())->toBeInstanceOf(HasOne::class);
});

// ═══════════════════════════════════════════
// PESANAN — relasi model Pesanan
// ═══════════════════════════════════════════

test('pesanan memiliki relasi belongsTo ke user sebagai client', function () {
    $pesanan = new Pesanan();
    expect($pesanan->client())->toBeInstanceOf(BelongsTo::class);
});

test('pesanan memiliki relasi belongsTo ke palletRequest', function () {
    $pesanan = new Pesanan();
    expect($pesanan->palletRequest())->toBeInstanceOf(BelongsTo::class);
});

test('pesanan memiliki relasi hasOne ke hpp', function () {
    $pesanan = new Pesanan();
    expect($pesanan->hpp())->toBeInstanceOf(HasOne::class);
});

// ═══════════════════════════════════════════
// MEETING REQUEST — relasi model MeetingRequest
// ═══════════════════════════════════════════

test('meetingRequest memiliki relasi belongsTo ke user sebagai client', function () {
    $meeting = new MeetingRequest();
    expect($meeting->user())->toBeInstanceOf(BelongsTo::class);
});

// ═══════════════════════════════════════════
// KUNJUNGAN — relasi model Kunjungan
// ═══════════════════════════════════════════

test('kunjungan memiliki relasi belongsTo ke user sebagai client', function () {
    $kunjungan = new Kunjungan();
    expect($kunjungan->client())->toBeInstanceOf(BelongsTo::class);
});

// ═══════════════════════════════════════════
// HPP — relasi model Hpp
// ═══════════════════════════════════════════

test('hpp memiliki relasi belongsTo ke pesanan', function () {
    $hpp = new Hpp();
    expect($hpp->pesanan())->toBeInstanceOf(BelongsTo::class);
});

// ═══════════════════════════════════════════
// PRODUK KAYU — relasi model ProdukKayu
// ═══════════════════════════════════════════

test('produkKayu memiliki relasi hasOne ke stok', function () {
    $produk = new ProdukKayu();
    expect($produk->stok())->toBeInstanceOf(HasOne::class);
});

test('produkKayu memiliki relasi belongsTo ke user sebagai admin', function () {
    $produk = new ProdukKayu();
    expect($produk->admin())->toBeInstanceOf(BelongsTo::class);
});

// ═══════════════════════════════════════════
// STOK KAYU — relasi model StokKayu
// ═══════════════════════════════════════════

test('stokKayu memiliki relasi belongsTo ke produkKayu', function () {
    $stok = new StokKayu();
    expect($stok->produk())->toBeInstanceOf(BelongsTo::class);
});

test('stokKayu memiliki relasi belongsTo ke user sebagai admin', function () {
    $stok = new StokKayu();
    expect($stok->admin())->toBeInstanceOf(BelongsTo::class);
});

// ═══════════════════════════════════════════
// PALET DESIGN — relasi model PaletDesign
// ═══════════════════════════════════════════

test('paletDesign memiliki relasi belongsTo ke user', function () {
    $design = new PaletDesign();
    expect($design->user())->toBeInstanceOf(BelongsTo::class);
});
