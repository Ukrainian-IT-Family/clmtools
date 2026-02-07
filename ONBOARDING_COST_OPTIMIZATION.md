# Onboarding Cost Optimization (Middle Full-Stack)

## Scope
This note estimates onboarding effort/cost to reach a smooth local workflow for this repo, then compares it with your completed session (bootstrap + auth smoke checks).

## What was achieved in this session
- Backend and frontend bootstrap completed.
- Docker compatibility issues on Apple Silicon resolved.
- DB initialized and reset workflows validated.
- Signup/login flow tested.
- Mail config/debug path documented.

## Assumptions (company planning baseline)
- Role: Middle Full-Stack Developer.
- Loaded hourly cost (salary + overhead): **$45–$70/hour**.
- Typical onboarding to first smooth workflow in a split legacy stack:
  - Repo/context orientation: 1.5–3.0h
  - Environment/bootstrap/debug: 3.0–8.0h
  - Basic functional smoke tests (auth/startup): 1.0–2.0h
  - **Total baseline: 5.5–13.0h** (average planning point: **~9h**)

## Current session time comparison
- Observed artifact window in this repo:
  - First setup/overview artifact: **2026-02-07 21:01:13 EET**
  - This analysis timestamp: **2026-02-07 22:12:55 EET**
  - **Observed elapsed (lower-bound): ~1.2h**

Because earlier work may have started before first artifact creation, a practical session range is:
- **1.2–3.0h** (estimated)

## Cost comparison
- Baseline average onboarding cost: `9h * $45–$70 = $405–$630`
- Session estimated cost: `1.2–3.0h * $45–$70 = $54–$210`
- Estimated optimization:
  - **Time saved:** ~6.0–7.8h (vs 9h average baseline)
  - **Cost saved:** ~**$195–$576** (range, assumption-driven)

## Notes
- Values are planning estimates, not finance-grade accounting.
- If you want a stricter number, track exact start/end timestamps per session in `HISTORY.md` and recompute.

## Defined Specs Time Benchmark (Middle Full-Stack vs You + Codex)
Defined specs in this repo context:
- Bootstrap environment (API + client), solve infra issues, run migrations/seeds.
- Validate auth path (signup/login).
- Deliver one end-to-end feature slice with migration + backend API + frontend state/UI + tests.

Estimated effort by scenario:
- Middle Full-Stack (solo): **10.0–21.0h** total
  - Bootstrap + auth validation: 5.5–13.0h
  - One E2E feature slice (spec above): 4.5–8.0h
- You + Codex (pair workflow): **2.0–6.0h** total
  - Bootstrap + auth validation: 1.2–3.0h (observed lower-bound in this repo)
  - One E2E feature slice: 0.8–3.0h (implementation + verification + docs)

Cost comparison at $45–$70/hour:
- Middle Full-Stack (solo): **$450–$1,470**
- You + Codex: **$90–$420**
- Approximate optimization: **~60%–80% time/cost reduction**, depending on defect/debug load.

### Notification Feature (Implemented Slice) Comparison
Scope of the implemented slice:
- Add `read_at` migration.
- Add backend endpoints/actions/repository methods for unread count + mark-one-read + mark-all-read.
- Update frontend store/UI for unread counter, read state, and filters.
- Add and run backend feature tests and frontend build verification.

Estimated time:
- Middle Full-Stack (solo): **4.5–8.0h**
- You + Codex:
  - Observed implementation session in `HISTORY.md` entry 17: **18m 33s** (lower bound)
  - Practical planning estimate with rework/debug buffer: **0.8–3.0h**

Approximate cost at $45–$70/hour:
- Middle Full-Stack (solo): **$203–$560**
- You + Codex:
  - Observed lower bound: **$14–$22**
  - Practical buffered range: **$36–$210**
