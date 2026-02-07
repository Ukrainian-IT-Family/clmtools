# Cost Usage Comparison (Bootstrap + Feature)

## Source data used
- `ONBOARDING_COST_OPTIMIZATION.md`
- `HISTORY.md` entry 16 (bootstrap/auth session timing)
- `HISTORY.md` entry 17 (notification feature implementation timing)

## Assumptions
- Developer loaded cost: **$45-$70/hour**
- "Real" usage below is based on **observed logged session durations** (lower-bound).

## Your observed usage (real, logged)
| Work item | Observed time | Hours | Cost at $45/h | Cost at $70/h |
|---|---:|---:|---:|---:|
| Bootstrap + auth validation | 1h 11m 42s | 1.20h | $53.78 | $83.65 |
| Notification feature slice | 18m 33s | 0.31h | $13.91 | $21.64 |
| **Total** | **1h 30m 15s** | **1.50h** | **$67.69** | **$105.29** |

## Middle full-stack solo baseline (planning point)
Baseline used from existing repo assumptions:
- Bootstrap average: **9.00h**
- Feature midpoint (4.5-8.0h): **6.25h**
- **Total baseline: 15.25h**

| Work item | Baseline time | Cost at $45/h | Cost at $70/h |
|---|---:|---:|---:|
| Bootstrap + auth validation | 9.00h | $405.00 | $630.00 |
| Notification feature slice | 6.25h | $281.25 | $437.50 |
| **Total** | **15.25h** | **$686.25** | **$1,067.50** |

## Real savings vs baseline (same hourly rate comparison)
| Metric | Bootstrap savings | Feature savings | Total savings |
|---|---:|---:|---:|
| Time saved | 7.80h | 5.94h | **13.75h** |
| Money saved at $45/h | $351.23 | $267.34 | **$618.56** |
| Money saved at $70/h | $546.35 | $415.86 | **$962.21** |

## Savings percentage
- Total time reduction: **~90.1%** (`13.75h / 15.25h`)
- Total cost reduction: **~90.1%** (same-rate comparison)

## Optional broader range check (from existing doc ranges)
- Solo total range: **10.0-21.0h**
- Observed total: **1.50h**
- Time saved range: **8.50-19.50h**
- Approx cost saved range: **$382.31-$1,364.71**

